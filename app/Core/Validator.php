<?php

namespace App\Core;

use App\Exception\ValidationException;

class Validator
{
    protected array $errors = [];
    protected array $data = [];

    private ?\mysqli $db;

    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $rulesSet) {
            $rulesArray = explode('|', $rulesSet);

            foreach ($rulesArray as $rule) {
                $ruleName = $rule;
                $parameter = null;

                // check for rules with parameters e.g. min:2
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $parameter] = explode(':', $rule);
                }

                // call the validate method
                $methodName = 'validate' . ucfirst($ruleName);
                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($field, $data[$field] ?? null, $parameter);
                }
            }
        }

        if (!empty($this->errors)) {
            throw new ValidationException($this->errors);
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function validateRequired($field, $value): void
    {
        if (empty($value)) {
            $this->errors[$field][] = "$field is required.";
        }
    }

    protected function validateEmail($field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field must be a valid email address.";
        }
    }

    protected function validateMin($field, $value, $min)
    {
        if (strlen($value) < $min) {
            $this->errors[$field][] = "$field must be at least $min characters.";
        }
    }

    protected function validateMax($field, $value, $max)
    {
        if (strlen($value) > $max) {
            $this->errors[$field][] = "$field must not exceed $max characters.";
        }
    }

    protected function validateNumeric($field, $value)
    {
        if (!is_numeric($value)) {
            $this->errors[$field][] = "$field must be a number.";
        }
    }

    protected function validateConfirmed($field, $value, $confirmationField): void
    {
        // Check if the confirmation field exists in the data and if it matches the original field
        if (!isset($this->data[$confirmationField]) || $value !== $this->data[$confirmationField]) {
            $this->errors[$field][] = "$field confirmation does not match.";
        }
    }

    protected function validateUnique($field, $value, $parameters): void
    {
        [$table, $column] = explode(',', $parameters);

        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE {$column} = ?");
        $type = '';
        if (is_int($value)) {
            $type = 'i';
        }
        if (is_string($value)) {
            $type = 's';
        }
        if (is_float($value)) {
            $type = 'd';
        } else {
            $type = 's';
        }
        $stmt->bind_param($type, $value);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $this->errors[$field][] = "$field must be unique.";
        }
        $stmt->close();
    }

    protected function validateEnum($field, $value, $parameter): void
    {
        $allowedValues = explode(',', $parameter);

        if (!in_array($value, $allowedValues, true)) {
            $this->errors[$field][] = "$field must be one of the following values: " . implode(', ', $allowedValues);
        }
    }
}