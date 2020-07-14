<?php

namespace marcopgordillo\Press\Tests;

use Orchestra\Testbench\TestCase;
use Parsedown;

use marcopgordillo\Press\MarkdownParser;

class MarkdownTest extends TestCase
{
    /** @test */
    public function simple_markdown_is_parsed_test(){
        $parsedown = new Parsedown();

        $parsedText = MarkdownParser::parse('# Heading');

        $this->assertEquals("<h1>Heading</h1>", $parsedText);
    }
}
