<?php


namespace marcopgordillo\Press\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use marcopgordillo\Press\Post;
use marcopgordillo\Press\PressFileParser;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Updates blog posts.';

    public function handle()
    {
        if (is_null(config('press'))) {
            return $this->warn("Please publish the config file by running 'php artisan vendor:publish --tag=press-config'");
        }

        // Fetch all posts
        $files = File::files(config('press.path'));

        // Process each file
        foreach ($files as $file) {
            $post = (new PressFileParser($file->getPathname()))->getData();
        }

        Post::create([
            'identifier' => Str::random(40),
            'slug' => Str::slug($post['title']),
            'title' => $post['title'],
            'body' => $post['body'],
            'extra' => $post['extra'] ?? json_encode([])
        ]);
    }
}
