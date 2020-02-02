<?php


namespace Yiisoft\File\Helper;


use Yiisoft\File\Exception\AdapterException;

/**
 * Class AdapterHelper
 * @package Yiisoft\File\Helper
 */
class AdapterHelper
{
    /**
     * @param array $attributes
     * @return array
     */
    public static function clear(array &$attributes)
    {
        if (count($attributes) == 0) {
            return $attributes;
        }

        foreach ($attributes as $key => &$attribute) {
            $attribute = trim($attribute);
            if ($attribute == null || strlen($attribute) == 0) {
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }

    /**
     * @param $attr
     * @param $attributes
     * @param string $exceptionClass
     */
    public static function validation(array $requiredAttributes, $attributes, $exceptionClass = AdapterException::class)
    {
        $attributes = (array)$attributes;
        foreach ($requiredAttributes as $key => $requiredAttribute) {
            if (is_array($requiredAttribute)) {
                self::validate($key, $requiredAttributes, $exceptionClass);
                self::validation($requiredAttribute, $attributes[$key], $exceptionClass);
            }
            self::validate($requiredAttribute, $attributes, $exceptionClass);
        }
    }

    /**
     * @param $attr
     * @param $attributes
     * @param string $exceptionClass
     */
    public static function validate($attr, $attributes, $exceptionClass = AdapterException::class)
    {
        $attributes = (array)$attributes;

        if (!array_key_exists($attr, $attributes)) {
            throw new $exceptionClass("The \"{$attr}\" property must be set.");
        }

        if (strlen(trim($attributes[$attr])) == 0) {
            throw new $exceptionClass("The \"{$attr}\" property must be set.");
        }
    }
}