<?php

namespace App\Requests;

/**
 * Abstract base class for form request validation.
 *
 * Provides input sanitization, validation orchestration, error management,
 * and validated data retrieval. Subclasses must implement validateData().
 *
 * @package App\Requests
 */
abstract class FormRequest
{
    /** @var array Sanitized input data. */
    protected array $data = [];

    /** @var array Validation errors keyed by field name. */
    protected array $errors = [];

    /**
     * Create a new form request with sanitized input data.
     *
     * @param array $data Raw input data (typically from $_POST).
     */
    public function __construct(array $data = [])
    {
        $this->data = $this->sanitize($data);
    }

    /**
     * Recursively sanitize input data by trimming whitespace and encoding HTML entities.
     *
     * @param  array $data Raw input data.
     * @return array Sanitized data.
     */
    protected function sanitize(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitize($value);
            } else {
                $sanitized[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
        }

        return $sanitized;
    }

    /**
     * Define field-specific validation rules. Must be implemented by subclasses.
     *
     * @return void
     */
    abstract protected function validateData(): void;

    /**
     * Run all validation rules and return whether the data is valid.
     *
     * @return bool True if no validation errors occurred.
     */
    public function validate(): bool
    {
        $this->errors = [];
        $this->validateData();

        return empty($this->errors);
    }

    /**
     * Return the full sanitized data array (used after successful validation).
     *
     * @return array
     */
    public function validated(): array
    {
        return $this->data;
    }

    /**
     * Get all validation errors concatenated into a single string.
     *
     * @return string Semicolon-separated error messages.
     */
    public function getErrorMessage(): string
    {
        return implode('; ', $this->errors);
    }

    /**
     * Register a validation error for a specific field.
     *
     * @param  string $field   The field identifier.
     * @param  string $message The error message.
     * @return void
     */
    protected function setError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    /**
     * Retrieve input data by key, or the full data array if no key is provided.
     *
     * @param  string|null $key     The data key to retrieve.
     * @param  mixed       $default Fallback value if the key does not exist.
     * @return mixed
     */
    public function getData(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->data;
        }

        return $this->data[$key] ?? $default;
    }

    /**
     * Check whether a value is present and non-empty after trimming.
     *
     * @param  mixed $value The value to check.
     * @return bool
     */
    protected function isRequired(mixed $value): bool
    {
        return !is_null($value) && trim((string) $value) !== '';
    }

    /**
     * Check whether a value is a valid non-negative integer.
     *
     * @param  mixed $value The value to check.
     * @return bool
     */
    protected function isNonNegativeInteger(mixed $value): bool
    {
        return $this->isRequired($value)
            && is_numeric($value)
            && (int) $value == (float) $value
            && (int) $value >= 0;
    }
}
