<?php

namespace marcopgordillo\Press\Fields;

use marcopgordillo\Press\MarkdownParser;

class Body
{
    public static function process($type, $value, $data)
    {
        return [
            $type => MarkdownParser::parse($value),
        ];
    }
}

