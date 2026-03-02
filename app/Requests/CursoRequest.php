<?php

namespace App\Requests;

/**
 * Validates input data for a course.
 *
 * Ensures the course name is present and contains no digits.
 *
 * @package App\Requests
 */
class CursoRequest extends FormRequest
{
    /** {@inheritdoc} */
    protected function validateData(): void
    {
        $name = $this->getData('nome');

        if (!$this->isRequired($name) || preg_match('/\d/', $name)) {
            $this->setError('nome', 'Invalid, missing or numeric name. Provide the name correctly.');
        }
    }
}
