<?php

namespace App\Requests;

use App\Models\Curso;
use App\Models\CursoEdicao;
use App\Models\Edicao;

/**
 * Validates input data for generating a convocation list.
 *
 * Ensures course and edition exist, the multiplication factor is a positive integer,
 * and the course-edition combination is valid.
 *
 * @package App\Requests
 */
class ConvocacaoRequest extends FormRequest
{
    /** {@inheritdoc} */
    protected function validateData(): void
    {
        $this->validateCourseId();
        $this->validateEditionId();
        $this->validateMultiplicationFactor();
        $this->validateCourseEditionCombination();
    }

    /**
     * Validate that the course ID refers to an existing course.
     */
    protected function validateCourseId(): void
    {
        $courseId = $this->getData('curso_id');

        if (!$this->isNonNegativeInteger($courseId) || !Curso::where('id', $courseId)->exists()) {
            $this->setError('curso_id', 'Invalid or unselected course. Please select an existing course.');
        }
    }

    /**
     * Validate that the edition ID refers to an existing edition.
     */
    protected function validateEditionId(): void
    {
        $editionId = $this->getData('edicao_id');

        if (!$this->isNonNegativeInteger($editionId) || !Edicao::where('id', $editionId)->exists()) {
            $this->setError('edicao_id', 'Invalid or unselected edition. Please select a valid edition.');
        }
    }

    /**
     * Validate that the multiplication factor is a positive integer (>= 1).
     */
    protected function validateMultiplicationFactor(): void
    {
        $factor = $this->getData('multiplicationFactor');

        if (!$this->isNonNegativeInteger($factor) || (int) $factor < 1) {
            $this->setError('multiplicationFactor', 'The multiplication factor must be a positive integer.');
        }
    }

    /**
     * Validate that the selected course-edition combination exists in the pivot table.
     */
    protected function validateCourseEditionCombination(): void
    {
        $courseId = $this->getData('curso_id');
        $editionId = $this->getData('edicao_id');

        if (!$courseId || !$editionId) {
            return;
        }

        if (!CursoEdicao::where('curso_id', $courseId)->where('edicao_id', $editionId)->exists()) {
            $this->setError('curso_edicao', 'The selected course and edition combination could not be found.');
        }
    }
}
