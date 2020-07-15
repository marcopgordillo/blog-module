<?php

namespace marcopgordillo\Press;

use Illuminate\Support\Facades\File;

use marcopgordillo\Press\Facades\Press;

class PressFileParser
{
    protected string $filename;
    protected array $data = [];
    protected array $rawData = [];

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

    public function getRawData(): Array
    {
        return $this->rawData;
    }

    protected function splitFile()
    {
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->filename) ? File::get($this->filename) : $this->filename,
            $this->rawData
        );
    }

    protected function explodeData()
    {
        foreach (explode("\n", trim($this->rawData[1])) as $fieldString) {
            preg_match('/(.*):\s?(.*)/', $fieldString, $fieldArray);

            $this->data[$fieldArray[1]] = $fieldArray[2];
        }

        $this->data['body'] = trim($this->rawData[2]);
    }

    protected function processFields()
    {
        foreach ($this->data as $field => $value) {
            $class = $this->getField($field);

            if (!class_exists($class)) {
                $class = 'marcopgordillo\\Press\\Fields\\Extra';
            }

            $this->data = array_merge(
                $this->data,
                $class::process($field, $value, $this->data)
            );
        }
    }

    private function getField($field)
    {
        $filteredFields = array_filter(Press::availableFields(), function ($availableField) use ($field) {
            $class = new \ReflectionClass($availableField);
            return $class->getShortName() == ucfirst($field);
        });

        return array_reduce($filteredFields, function ($acc, $f) {
            try {
                $class = new \ReflectionClass($f);
                return $class->getName();
            } catch (\ReflectionException $e) {
                $this->error($e->getMessage());
            }
            return $f;
        }, '');

//        foreach (Press::availableFields() as $availableField) {
//            try {
//                $class = new \ReflectionClass($availableField);
//
//                if ($class->getShortName() == ucfirst($field)) {
//                    return $class->getName();
//                }
//            } catch (\ReflectionException $e) {
//                $this->error($e->getMessage());
//            }
//        }
    }
}
