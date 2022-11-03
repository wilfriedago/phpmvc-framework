<?php

declare(strict_types=1);

namespace App\Core;

class Validator
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';

    public array $data = [];
    public array $rules = [];
    public array $errors = [];

    private Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $rules
     * @return void
     */
    public function rules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules as $attribute => $attributeRules) {
            $value = $this->model->{$attribute};

            foreach ($attributeRules as $rule => $ruleValue) {
                if (!is_string($rule)) {
                    $rule = $ruleValue;
                }

                if ($rule === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, "This field is required");
                }

                if ($rule === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, "This field must be a valid email address");
                }

                if ($rule === self::RULE_MIN && strlen($value) < $ruleValue) {
                    $this->addError($attribute, "This field must be a minimum of $ruleValue characters");
                }

                if ($rule === self::RULE_MAX && strlen($value) > $ruleValue) {
                    $this->addError($attribute, "This field must be a maximum of $ruleValue characters");
                }

                if ($rule === self::RULE_MATCH && $value !== $this->model->{$ruleValue}) {
                    $this->addError($attribute, "This field must be the same as $ruleValue");
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * @param $attribute
     * @param $message
     * @return void
     */
    public function addError($attribute, $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError()
    {
        return $this->errors[array_key_first($this->errors)] ?? false;
    }
}
