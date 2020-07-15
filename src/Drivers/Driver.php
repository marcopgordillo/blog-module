<?php


namespace marcopgordillo\Press\Drivers;


use Illuminate\Support\Str;
use marcopgordillo\Press\PressFileParser;

abstract class Driver
{
    protected $config;
    protected $posts = [];

    public function __construct()
    {
        $this->setConfig();

        $this->validateSource();
    }

    protected function setConfig()
    {
        $this->config =  config('press.' . config('press.driver'));
    }

    protected function validateSource()
    {
        return true;
    }

    public abstract function fetchPosts();

    protected function parse($content, $identifier)
    {
        $this->posts[] = array_merge(
            (array) (new PressFileParser($content))->getData(),
            ['identifier' => Str::slug($identifier)]
        );
    }
}
