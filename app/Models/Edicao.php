<?php

namespace App\Models;

use App\Traits\SaveMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Eloquent model representing a SISU edition (selection period).
 *
 * Uses the SaveMany trait for atomic master-detail persistence with courses.
 *
 * @property int    $id
 * @property string $nome
 *
 * @package App\Models
 */
class Edicao extends Model
{
    use SaveMany;

    protected $table = 'edicoes';
    public $timestamps = false;

    protected $fillable = ['nome'];

    /**
     * Get the courses associated with this edition (many-to-many with vacancy pivot data).
     */
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(
            Curso::class,
            'curso_edicao',
            'edicao_id',
            'curso_id'
        )
        ->using(CursoEdicao::class)
        ->withPivot(
            'vagas_ac',
            'vagas_ppi_br',
            'vagas_publica_br',
            'vagas_ppi_publica',
            'vagas_publica',
            'vagas_deficientes'
        );
    }

    /**
     * Get all candidates registered in this edition.
     */
    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class, 'edicao_id', 'id');
    }
}
