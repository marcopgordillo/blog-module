<?php

namespace marcopgordillo\Press\Fields;

use marcopgordillo\Press\MarkdownParser;

class Body
{
    public static function process($type, $value)
    {
        return [
            $type => MarkdownParser::parse($value),
        ];
    }
}

