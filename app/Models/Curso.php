<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Eloquent model representing an academic course.
 *
 * @property int    $id
 * @property string $nome
 *
 * @package App\Models
 */
class Curso extends Model
{
    protected $table = 'cursos';
    public $timestamps = false;

    protected $fillable = ['nome'];

    /**
     * Get the editions associated with this course (many-to-many with vacancy pivot data).
     */
    public function edicoes(): BelongsToMany
    {
        return $this->belongsToMany(
            Edicao::class,
            'curso_edicao',
            'curso_id',
            'edicao_id'
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
     * Get all candidates enrolled in this course.
     */
    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class, 'curso_id', 'id');
    }
}
