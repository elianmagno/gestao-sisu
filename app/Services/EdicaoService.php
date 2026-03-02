<?php

namespace App\Services;

use App\Models\Edicao;

/**
 * Service responsible for edition CRUD business logic.
 *
 * Delegates master-detail persistence to the SaveMany trait on the Edicao model.
 *
 * @package App\Services
 */
class EdicaoService
{
    /**
     * Create a new edition with its associated course vacancies.
     *
     * @param  array $data Validated data containing 'nome' and optional 'cursos' pivot array.
     * @return Edicao
     */
    public function store(array $data): Edicao
    {
        $edition = new Edicao();
        $edition->nome = $data['nome'];

        $edition->saveMany($this->buildPivotData($data['cursos'] ?? []), 'cursos');

        return $edition;
    }

    /**
     * Update an existing edition and synchronize its course vacancies.
     *
     * @param  Edicao $edition The edition model instance to update.
     * @param  array  $data    Validated data containing 'nome' and optional 'cursos' pivot array.
     * @return Edicao
     */
    public function update(Edicao $edition, array $data): Edicao
    {
        $edition->nome = $data['nome'];

        $edition->saveMany($this->buildPivotData($data['cursos'] ?? []), 'cursos');

        return $edition;
    }

    /**
     * Delete an edition and its associated data (candidates and course links).
     *
     * @param  Edicao $edition The edition model instance to delete.
     * @return bool
     */
    public function destroy(Edicao $edition): bool
    {
        $edition->candidatos()->delete();
        $edition->cursos()->detach();

        return $edition->delete();
    }

    /**
     * Transform raw course form data into the pivot format expected by saveMany.
     *
     * @param  array $coursesData Raw form array with course IDs and vacancy counts.
     * @return array Formatted pivot data array.
     */
    protected function buildPivotData(array $coursesData): array
    {
        $pivotData = [];

        foreach ($coursesData as $pivot) {
            $pivotData[] = [
                'curso_id'          => (int) $pivot['curso_id'],
                'vagas_ac'          => (int) $pivot['vagas_ac'],
                'vagas_ppi_br'      => (int) $pivot['vagas_ppi_br'],
                'vagas_publica_br'  => (int) $pivot['vagas_publica_br'],
                'vagas_ppi_publica' => (int) $pivot['vagas_ppi_publica'],
                'vagas_publica'     => (int) $pivot['vagas_publica'],
                'vagas_deficientes' => (int) $pivot['vagas_deficientes'],
            ];
        }

        return $pivotData;
    }
}
