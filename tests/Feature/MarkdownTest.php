<?php

namespace marcopgordillo\Press\Tests;

use Orchestra\Testbench\TestCase;

use marcopgordillo\Press\MarkdownParser;

class MarkdownTest extends TestCase
{
    /** @test */
    public function simple_markdown_is_parsed_test(){
        $parsedText = MarkdownParser::parse('# Heading');

        $this->assertEquals("<h1>Heading</h1>", $parsedText);
    }
}
