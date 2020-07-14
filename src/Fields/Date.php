<?php

namespace marcopgordillo\Press\Fields;

use Carbon\Carbon;

class Date
{
    public static function process($type, $value, $data)
    {
        return [
            $type => Carbon::parse($value),
            'parsed_at' => Carbon::now(),
        ];
    }
}
