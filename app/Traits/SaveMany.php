<?php

namespace App\Traits;

use Illuminate\Support\Arr;

/**
 * Trait for transactional master-detail persistence with BelongsToMany relationships.
 *
 * Saves the parent model and synchronises the specified pivot relationship
 * inside a single database transaction, rolling back on failure.
 *
 * @package App\Traits
 */
trait SaveMany
{
    /**
     * Persist the model and synchronise a BelongsToMany relationship atomically.
     *
     * @param  array  $pivotData Array of associative arrays with related key and pivot column values.
     * @param  string $relation  Name of the BelongsToMany relationship method on this model.
     * @return bool              True on success.
     *
     * @throws \Exception Re-throws any exception after rolling back.
     */
    public function saveMany(array $pivotData, string $relation): bool
    {
        $connection = $this->getConnection();
        $connection->beginTransaction();

        try {
            if (!$this->save()) {
                $connection->rollBack();
                return false;
            }

            $relatedKey = $this->$relation()->getRelatedPivotKeyName();
            $syncData   = [];

            foreach ($pivotData as $pivotRecord) {
                $relatedKeyId            = $pivotRecord[$relatedKey];
                $syncData[$relatedKeyId] = Arr::except($pivotRecord, [$relatedKey]);
            }

            $this->$relation()->sync($syncData);

            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}
