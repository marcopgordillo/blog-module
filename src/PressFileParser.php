<?php

namespace marcopgordillo\Press;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PressFileParser
{
    protected String $filename;
    protected Array $data = [];

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->splitFile();
        $this->explodeData();
        $this->processFields();
    }

    public function getData(): Array
    {
        return $this->data;
    }

    protected function splitFile()
    {
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->filename) ? File::get($this->filename) : $this->filename,
            $this->data
        );
    }

    protected function explodeData()
    {
        foreach (explode("\n", trim($this->data[1])) as $fieldString) {
            preg_match('/(.*):\s?(.*)/', $fieldString, $fieldArray);
            $this->data[$fieldArray[1]] = $fieldArray[2];
        }

        $this->data['body'] = trim($this->data[2]);
    }

    protected function processFields()
    {
        foreach ($this->data as $field => $value) {
            // if ($field === 'date') {
                // $this->data[$field] = Carbon::parse($value);
            // } else if ($field === 'body') {
                // $this->data[$field] = MarkdownParser::parse($value);
            // }
            $class = 'marcopgordillo\\Press\\Fields\\' . ucfirst($field);

            if (class_exists($class) && method_exists($class, 'process')) {
                $this->data = array_merge(
                    $this->data,
                    $class::process($field, $value)
                );
            }
        }
    }
}
