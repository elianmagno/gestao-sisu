<?php

namespace App\Requests;

use App\Models\Curso;

/**
 * Validates input data for an edition.
 *
 * Ensures the edition name is provided and validates each associated course's
 * vacancy fields (non-negative integers, at least 1 total vacancy per course).
 *
 * @package App\Requests
 */
class EdicaoRequest extends FormRequest
{
    /** {@inheritdoc} */
    protected function validateData(): void
    {
        $this->validateName();
        $this->validateCourses();
    }

    /**
     * Validate that the edition name is present.
     */
    protected function validateName(): void
    {
        if (!$this->isRequired($this->getData('nome'))) {
            $this->setError('nome', 'Invalid or missing name. Provide the name correctly.');
        }
    }

    /**
     * Validate each associated course: existence, vacancy values and minimum total.
     */
    protected function validateCourses(): void
    {
        $courses = $this->getData('cursos');

        if (!is_array($courses) || empty($courses)) {
            return;
        }

        $vacancyKeys = [
            'vagas_ac',
            'vagas_ppi_br',
            'vagas_publica_br',
            'vagas_ppi_publica',
            'vagas_publica',
            'vagas_deficientes',
        ];

        foreach ($courses as $pivot) {
            $courseId = $pivot['curso_id'] ?? null;

            if (!$this->isRequired($courseId) || !Curso::where('id', $courseId)->exists()) {
                $this->setError("curso_{$courseId}", 'The provided course is invalid or does not exist.');
                continue;
            }

            $courseName = Curso::find($courseId)->nome;
            $vacancies = [];

            foreach ($vacancyKeys as $key) {
                if (!$this->isNonNegativeInteger($pivot[$key] ?? null)) {
                    $this->setError("curso_{$courseId}_{$key}", "In course \"{$courseName}\", one or more vacancy fields contain invalid values.");
                    continue 2;
                }

                $vacancies[] = (int) $pivot[$key];
            }

            if (array_sum($vacancies) < 1) {
                $this->setError("curso_{$courseId}_total", "In course \"{$courseName}\", the total number of vacancies must be at least 1.");
            }
        }
    }
}
