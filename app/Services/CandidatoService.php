<?php

namespace App\Services;

use App\Models\Candidato;

/**
 * Service responsible for candidate CRUD business logic.
 *
 * @package App\Services
 */
class CandidatoService
{
    /**
     * Create a new candidate from validated data.
     *
     * @param  array $data Validated candidate attributes.
     * @return Candidato
     */
    public function store(array $data): Candidato
    {
        return Candidato::create($data);
    }

    /**
     * Update an existing candidate with validated data.
     *
     * @param  Candidato $candidate The candidate model instance to update.
     * @param  array     $data      Validated candidate attributes.
     * @return Candidato
     */
    public function update(Candidato $candidate, array $data): Candidato
    {
        $candidate->update($data);

        return $candidate;
    }

    /**
     * Delete a candidate record.
     *
     * @param  Candidato $candidate The candidate model instance to delete.
     * @return bool
     */
    public function destroy(Candidato $candidate): bool
    {
        return $candidate->delete();
    }
}
