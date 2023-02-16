<?php
namespace App\Helper;

use App\Model\Model;

class Validator
{
    private array $fields;
    private array $errors;

    private string $lastField;
    public function __construct(array $fields)
    {
        foreach ($fields as $key => $value) {
            $this->errors[$key] = [];
            $this->fields[$key] = (string) $value;
            $this->lastField = $key;
        }
    }

    public static function validate(array $fields): Validator
    {
        return new Validator($fields);
    }

    public function errors()
    {
        foreach ($this->errors as $value) {
            if (count($value)) {
                return $this->errors;
            }
        }
        return false;
    }

    public function isUnique(string $table, string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }
        foreach (Model::all()[$table] as $record) {
            if ($record[$fieldName] === $this->fields[$fieldName]) {
                $this->errors[$fieldName][] = $fieldName . ' is not unique';
                break;
            }
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function min(int $min, string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (strlen($this->fields[$fieldName]) < $min) {
            $this->errors[$fieldName][] = $fieldName . ' is too short';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function max(int $max, string $fieldName= ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (strlen($this->fields[$fieldName]) > $max) {
            $this->errors[$fieldName][] = $fieldName . ' is too long';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function hasDigits(string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (!preg_match('/\d/', $this->fields[$fieldName])) {
            $this->errors[$fieldName][] = $fieldName . ' does not have digits';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function hasLetters(string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (!preg_match('/[a-z]/i', $this->fields[$fieldName])) {
            $this->errors[$fieldName][] = $fieldName . ' does not have letters';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function onlyLetters(string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (!preg_match('/^[a-z]*$/i', $this->fields[$fieldName])) {
            $this->errors[$fieldName][] = $fieldName . ' has banned characters';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function noSpaces(string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (preg_match('/\s/', $this->fields[$fieldName])) {
            $this->errors[$fieldName][] = $fieldName . ' has spaces';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function noSpecials(string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (preg_match('/[^a-z0-9 ]/i', $this->fields[$fieldName])) {
            $this->errors[$fieldName][] = $fieldName . ' has special characters';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function isEmail(string $fieldName = ''): Validator
    {
        if ($fieldName === '') {
            $fieldName = $this->lastField;
        }

        if (!preg_match('/^\w+@\w+\.[a-z]{2,}$/i', $this->fields[$fieldName])) {
            $this->errors[$fieldName][] = $fieldName . ' is not valid';
        }
        $this->lastField = $fieldName;
        return $this;
    }

    public function areFieldsEqual(string $fieldName1, string $fieldName2): Validator
    {
        if ($this->fields[$fieldName1] != $this->fields[$fieldName2]){
            $this->errors[$fieldName1][] = $fieldName1 . ' is not equal to ' . $fieldName2;
            $this->errors[$fieldName2][] = $fieldName2 . ' is not equal to ' . $fieldName1;
        }
        return $this;
    }
}