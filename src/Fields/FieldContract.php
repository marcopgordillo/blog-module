<?php

namespace marcopgordillo\Press\Fields;

abstract class FieldContract
{
    public static function process($fieldType, $fieldValue, $data)
    {
        return [
            $fieldType => $fieldValue,
        ];
    }
}


