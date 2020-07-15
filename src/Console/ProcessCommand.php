<?php


namespace marcopgordillo\Press\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use marcopgordillo\Press\Post;
use marcopgordillo\Press\Press;
use marcopgordillo\Press\PressFileParser;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Updates blog posts.';

    public function handle()
    {
        if (Press::configNotPublished()) {
            return $this->warn("Please publish the config file by running 'php artisan vendor:publish --tag=press-config'");
        }

        // Fetch all posts
        $posts = Press::driver()->fetchPosts();

//        dd($posts);
        foreach ($posts as $post) {
            Post::create([
                'identifier' => Str::random(40),
                'slug' => Str::slug($post['title']),
                'title' => $post['title'],
                'body' => $post['body'],
                'extra' => $post['extra'] ?? json_encode([])
            ]);
        }
    }
}
