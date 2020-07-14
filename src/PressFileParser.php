<?php

namespace marcopgordillo\Press;

use Illuminate\Support\Facades\File;

class PressFileParser
{
    protected String $filename;
    protected Array $data = [];

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->splitFile();
    }

    public function getData(): Array
    {
        return $this->data;
    }

    private function splitFile()
    {
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::get($this->filename),
            $this->data
        );
    }
}
