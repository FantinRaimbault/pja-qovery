<?php

namespace App\Core\Html;

class FormValidator
{

    public function __construct(
        private bool $required = true,
        private int|null $minLength = null,
        private int|null $maxLength = null,
        private string|null $regex = null,
        private array|null $contains = null,
        private bool|null $email = null,
        private string|null $equalTo = null,
        private string|null $min = null
    ) {
    }

    public function isValid($value, $formData): bool
    {
        if ($this->required || (!$this->required && !empty($value))) {
            $value = trim($value);
            if (!is_null($this->minLength) && strlen($value) < $this->minLength) {
                return false;
            }
            if (!is_null($this->maxLength) && strlen($value) > $this->maxLength) {
                return false;
            }
            if (!is_null($this->regex) && !preg_match($this->regex, $value)) {
                return false;
            }
            if (!is_null($this->contains) && !in_array($value, $this->contains)) {
                return false;
            }
            if (!is_null($this->email) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            if (!is_null($this->equalTo) && $value !== $formData[$this->equalTo]) {
                return false;
            }
            if (!is_null($this->min) && $value <= $this->min) {
                return false;
            }
        }
        return true;
    }
}
