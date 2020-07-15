<?php


namespace marcopgordillo\Press\Drivers;


use Illuminate\Support\Facades\File;

use marcopgordillo\Press\PressFileParser;

class FileDriver
{
    public function fetchPosts()
    {
        $files = File::files(config('press.path'));

        foreach ($files as $file) {
            $posts[] = (new PressFileParser($file->getPathname()))->getData();
        }

        return $posts ?? [];
    }
}
