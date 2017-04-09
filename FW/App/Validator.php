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
     *  'username' => ['minlength'=> number, 'maxlength'=> number, 'match'=> regex],
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
     * @return array|bool
     */
    public function validate($storage)
    {
        $errors = [];
        foreach ($this->rules as $ruleSet) {
            foreach ($ruleSet as $fieldName => $rules) {
                foreach ($rules as $ruleName => $ruleValue) {
                    if (!$this->isValid($ruleName, $ruleValue, $storage[$fieldName])) {
                        if (!isset($errors[$fieldName])) {
                            $errors[$fieldName] = [];
                        }
                        $errors[$fieldName][$ruleName] = false;
                    }
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
        return true;
    }
}