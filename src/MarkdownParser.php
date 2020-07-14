<?php

namespace marcopgordillo\Press;

class MarkdownParser
{
    public static function parse(String $string)
    {
        // $parsedown = new \Parsedown();

        // return $parsedown->text($string);
        return \Parsedown::instance()->text($string);
    }
}
