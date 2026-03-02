<?php

namespace App\Services;

use App\Models\Curso;

/**
 * Service responsible for course CRUD business logic.
 *
 * @package App\Services
 */
class CursoService
{
    /**
     * Create a new course from validated data.
     *
     * @param  array $data Validated course attributes.
     * @return Curso
     */
    public function store(array $data): Curso
    {
        return Curso::create($data);
    }

    /**
     * Update an existing course with validated data.
     *
     * @param  Curso $course The course model instance to update.
     * @param  array $data   Validated course attributes.
     * @return Curso
     */
    public function update(Curso $course, array $data): Curso
    {
        $course->update($data);

        return $course;
    }

    /**
     * Delete a course and its associated data (candidates and edition links).
     *
     * @param  Curso $course The course model instance to delete.
     * @return bool
     */
    public function destroy(Curso $course): bool
    {
        $course->candidatos()->delete();
        $course->edicoes()->detach();

        return $course->delete();
    }
}
