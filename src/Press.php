<?php


namespace marcopgordillo\Press;


class Press
{
    public static function configNotPublished()
    {
        return (is_null(config('press')));
    }

    public static function driver()
    {
        $driver = ucfirst(config('press.driver'));

        $class = 'marcopgordillo\Press\Drivers\\' . $driver . 'Driver';

        return new $class;
    }

    public static function path()
    {
        return config('press.path', 'blogs');
    }
}
