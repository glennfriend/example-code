<?php

namespace Modules\Contact\Concerns;

use InvalidArgumentException;

/**
 *  Support
 *      --filter="name=string:hello world"
 *      --filter="name=bool:false"
 *      --filter="name=int:-100"
 *      --filter="name=bool:true"
 * 
 *  是否有考慮改成 ????
 *      --filter="name:string=hello world"
 *      --filter="name:?string=null"
 *      --filter="name:int=-100"
 *      --filter="name:bool=true"
 * 
 */
trait Optionable
{
    public function getAllOptions(): array
    {
        static $allOpations;
        if ($allOpations) {
            return $allOpations;
        }

        $allOpations = [];
        foreach ($this->getOptionableParameterKeys() as $parameterName) {
            $allOpations[$parameterName] = $this->parseOption($parameterName);
        }
        return $allOpations;
    }

    private function parseOption(string $field): array
    {
        $filters = [];
        foreach ($this->option($field) as $condition) {
            list($key, $valueCondition) = explode('=', $condition);
            $filters[trim($key)] = $this->parseParameterFormat($valueCondition, $key);
        }
        return $filters;
    }

    private function parseParameterFormat(string $target, string $key): string|int|bool|null
    {
        list($valueType, $value) = explode(':', $target);
        switch ($valueType) {
            case 'int':
                $value = (int)$value;
                break;
            case 'bool':
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if (!is_bool($value)) {
                    throw new InvalidArgumentException("key `{$key}` invalid boolean value");
                }
                break;
            case 'type':
                $value = trim($value);
                break;
            case 'copy':
                $value = trim($value);
                break;
            default:
                $value = trim($value);
                break;
        }
        return $value;
    }
}
