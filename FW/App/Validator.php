<?php


namespace FW\App;

class Validator
{
    const MIN = 'min';
    const MAX = 'max';
    const MIN_LENGTH = 'minLength';
    const MAX_LENGTH = 'maxLength';
    const MATCH = 'match';
    const TYPE = 'type';

    const TYPE_NUMBER = 1;
    const TYPE_INT = 2;
    const TYPE_EMAIL = 3;
    const TYPE_URL = 4;

    private $rules;

    /**
     * [
     *  'username' => ['minLength'=> number, 'maxLength'=> number, 'match'=> regex],
     *  'age' => ['min'=> number, 'max'=> number]
     * ]
     * @param array $rules
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param $storage
     * Returns names of failed rules in case of failure, or true if all rules are fulfilled
     * @return string[]|bool
     */
    public function validate($storage)
    {
        $errors = [];
        foreach ($this->rules as $fieldName => $rules) {
            foreach ($rules as $ruleName => $ruleValue) {
                if (!$this->isValid($ruleName, $ruleValue, $storage[$fieldName])) {
                    if (!isset($errors[$fieldName])) {
                        $errors[$fieldName] = [];
                    }
                    $errors[$fieldName][] = $ruleName;
                }
            }
        }
        return empty($errors) ? true : $errors;
    }

    private function isValid($rule, $ruleValue, $value)
    {
        switch ($rule) {
            case self::MIN:
                return $value >= $ruleValue;
            case self::MAX:
                return $value <= $ruleValue;
            case self::MIN_LENGTH:
                return strlen($value) >= $ruleValue;
            case self::MAX_LENGTH:
                return strlen($value) <= $ruleValue;
            case self::MATCH:
                return preg_match($ruleValue, $value) === 1;
            case self::TYPE:
                return $this->isOfType($ruleValue, $value);
        }
        return false;
    }

    private function isOfType($type, $value)
    {
        switch ($type) {
            case self::TYPE_INT:
                return filter_var($value, FILTER_VALIDATE_INT);// is_int($value)
            case self::TYPE_EMAIL:
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            case self::TYPE_URL:
                return filter_var($value, FILTER_VALIDATE_URL);
        }
        return true;
    }
}