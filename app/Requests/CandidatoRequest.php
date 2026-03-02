<?php

namespace App\Requests;

use App\Models\Candidato;
use App\Models\Curso;
use App\Models\CursoEdicao;
use App\Models\Edicao;
use Illuminate\Support\Carbon;

/**
 * Validates input data for a candidate.
 *
 * Covers name, CPF (with check digit verification), birth date, admission category,
 * course/edition existence, score range, CPF uniqueness per edition, and course-edition compatibility.
 *
 * @package App\Requests
 */
class CandidatoRequest extends FormRequest
{
    /** {@inheritdoc} */
    protected function validateData(): void
    {
        $this->validateName();
        $this->validateCPF();
        $this->validateBirthDate();
        $this->validateCategory();
        $this->validateCourseId();
        $this->validateEditionId();
        $this->validateScore();
        $this->validateCPFUniqueForEdition();
        $this->validateCourseInEdition();
    }

    /**
     * Validate that the name is present and contains no digits.
     */
    protected function validateName(): void
    {
        $name = $this->getData('nome');

        if (!$this->isRequired($name) || preg_match('/\d/', $name)) {
            $this->setError('nome', 'Invalid or missing full name. Provide the complete name correctly.');
        }
    }

    /**
     * Validate CPF format (11 digits) and verify check digits using the standard algorithm.
     */
    protected function validateCPF(): void
    {
        $cpf = $this->getData('cpf');

        if (
            !$this->isNonNegativeInteger($cpf)
            || mb_strlen($cpf, 'UTF-8') !== 11
            || preg_match('/(\d)\1{10}/', $cpf)
        ) {
            $this->setError('cpf', 'Invalid CPF. It must contain exactly 11 valid numeric digits.');
            return;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += (int) $cpf[$c] * (($t + 1) - $c);
            }
            $d = (($d * 10) % 11) % 10;
            if ((int) $cpf[$c] !== $d) {
                $this->setError('cpf', 'Invalid CPF. It must contain exactly 11 valid numeric digits.');
                return;
            }
        }
    }

    /**
     * Validate that the birth date is a valid past date in YYYY-MM-DD format.
     */
    protected function validateBirthDate(): void
    {
        $birthDate = $this->getData('data_nascimento');

        if (!$this->isRequired($birthDate)) {
            $this->setError('data_nascimento', 'Invalid birth date or incorrect format. Use the YYYY-MM-DD format.');
            return;
        }

        $date = Carbon::createFromFormat('Y-m-d', $birthDate, null, ['strict' => true]);

        if ($date === false || $date->isFuture()) {
            $this->setError('data_nascimento', 'Invalid birth date or incorrect format. Use the YYYY-MM-DD format.');
        }
    }

    /**
     * Validate that the selected category is one of the allowed admission categories.
     */
    protected function validateCategory(): void
    {
        $categories = [
            'Ampla Concorrência',
            'PPI - Pública - Baixa Renda',
            'Pública - Baixa Renda',
            'PPI - Pública',
            'Pública',
            'Deficientes',
        ];

        $category = $this->getData('categoria');

        if (!$this->isRequired($category) || !in_array($category, $categories, true)) {
            $this->setError('categoria', 'Invalid or unselected admission category. Please choose a valid category.');
        }
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
     * Validate that the score is a numeric value between 0 and 1000.
     */
    protected function validateScore(): void
    {
        $score = $this->getData('nota');

        if (!$this->isRequired($score) || !is_numeric($score) || (float) $score < 0 || (float) $score > 1000) {
            $this->setError('nota', 'Invalid score. Enter a numeric value between 0 and 1000.');
        }
    }

    /**
     * Validate that the CPF is not already registered in the same edition.
     * On update, the current record is excluded from the uniqueness check.
     */
    protected function validateCPFUniqueForEdition(): void
    {
        $cpf = $this->getData('cpf');
        $editionId = $this->getData('edicao_id');
        $id = $this->getData('id');

        if (!$cpf || !$editionId) {
            return;
        }

        $query = Candidato::where('cpf', $cpf)->where('edicao_id', $editionId);

        if ($id) {
            $query->where('id', '!=', $id);
        }

        if ($query->exists()) {
            $this->setError('cpf_unique', 'CPF is already registered for this edition. Each CPF can only be registered once per edition.');
        }
    }

    /**
     * Validate that the selected course is available in the chosen edition.
     */
    protected function validateCourseInEdition(): void
    {
        $courseId = $this->getData('curso_id');
        $editionId = $this->getData('edicao_id');

        if (!$courseId || !$editionId) {
            return;
        }

        if (!CursoEdicao::where('curso_id', $courseId)->where('edicao_id', $editionId)->exists()) {
            $this->setError('curso_in_edition', 'The selected course is not available in the chosen edition. Please verify compatibility.');
        }
    }
}
