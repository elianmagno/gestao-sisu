<?php

namespace App\Services;

use App\Models\Candidato;
use App\Models\Curso;
use App\Models\CursoEdicao;
use App\Models\Edicao;

class ConvocacaoService
{
    /** @var array Maps vacancy column names to their display category labels. */
    protected static array $categories = [
        'vagas_ac'          => 'Ampla Concorrência',
        'vagas_ppi_br'      => 'PPI - Pública - Baixa Renda',
        'vagas_publica_br'  => 'Pública - Baixa Renda',
        'vagas_ppi_publica' => 'PPI - Pública',
        'vagas_publica'     => 'Pública',
        'vagas_deficientes' => 'Deficientes',
    ];

    /**
     * Generate the convocation list for a given course, edition, and multiplication factor.
     *
     * For each admission category, retrieves the top candidates ordered by score (desc)
     * and marks them as classified/approved or not classified.
     *
     * @param  array $data Validated data with 'curso_id', 'edicao_id', and 'multiplicationFactor'.
     * @return array Associative array with 'selectedCourse', 'selectedEdition',
     *               'calledCandidates', and 'multiplicationFactor'.
     */
    public function generate(array $data): array
    {
        $courseEdition = CursoEdicao::where('curso_id', $data['curso_id'])
            ->where('edicao_id', $data['edicao_id'])
            ->sole();

        $multiplicationFactor = (int) $data['multiplicationFactor'];

        $calledCandidates = [];

        foreach (self::$categories as $column => $categoryName) {
            $vacancyCount = $courseEdition->$column;

            $calledCandidates[$categoryName] = Candidato::where('curso_id', $data['curso_id'])
                ->where('edicao_id', $data['edicao_id'])
                ->where('categoria', $categoryName)
                ->orderBy('nota', 'desc')
                ->take($multiplicationFactor * $vacancyCount)
                ->get()
                ->map(function ($candidate, $index) use ($vacancyCount) {
                    $candidate->situacao = ($index < $vacancyCount)
                        ? 'Classificado/Aprovado'
                        : 'Não Classificado';

                    return $candidate;
                });
        }

        return [
            'selectedCourse'       => Curso::find($data['curso_id']),
            'selectedEdition'      => Edicao::find($data['edicao_id']),
            'calledCandidates'     => $calledCandidates,
            'multiplicationFactor' => $multiplicationFactor,
        ];
    }
}
