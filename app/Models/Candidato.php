<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Eloquent model representing a candidate enrolled in a course edition.
 *
 * @property int    $id
 * @property string $nome
 * @property string $cpf
 * @property string $data_nascimento
 * @property string $categoria
 * @property int    $curso_id
 * @property int    $edicao_id
 * @property float  $nota
 *
 * @package App\Models
 */
class Candidato extends Model
{
    protected $table = 'candidatos';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'categoria',
        'curso_id',
        'edicao_id',
        'nota',
    ];

    /**
     * Get the course this candidate is enrolled in.
     */
    public function cursos(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id');
    }

    /**
     * Get the edition this candidate belongs to.
     */
    public function edicoes(): BelongsTo
    {
        return $this->belongsTo(Edicao::class, 'edicao_id', 'id');
    }
}
