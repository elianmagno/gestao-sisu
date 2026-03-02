<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Pivot model for the course-edition relationship, holding vacancy data per admission category.
 *
 * @property int $id
 * @property int $edicao_id
 * @property int $curso_id
 * @property int $vagas_ac
 * @property int $vagas_ppi_br
 * @property int $vagas_publica_br
 * @property int $vagas_ppi_publica
 * @property int $vagas_publica
 * @property int $vagas_deficientes
 *
 * @package App\Models
 */
class CursoEdicao extends Pivot
{
    protected $table = 'curso_edicao';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'edicao_id',
        'curso_id',
        'vagas_ac',
        'vagas_ppi_br',
        'vagas_publica_br',
        'vagas_ppi_publica',
        'vagas_publica',
        'vagas_deficientes',
    ];
}
