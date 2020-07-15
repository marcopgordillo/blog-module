<?php


namespace marcopgordillo\Press;


class Press
{
    protected $fields = [];

    public function configNotPublished()
    {
        return (is_null(config('press')));
    }

    public function driver()
    {
        $driver = ucfirst(config('press.driver'));

        $class = 'marcopgordillo\Press\Drivers\\' . $driver . 'Driver';

        return new $class;
    }

    public function path()
    {
        return config('press.path', 'blogs');
    }

    public function fields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
    }

    public function availableFields()
    {
        return array_reverse($this->fields);
    }
}
