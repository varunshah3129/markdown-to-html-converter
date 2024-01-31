<?php
use PHPUnit\Framework\TestCase;

require 'markdownToHtml.php';

class MarkdownToHtmlTest extends TestCase {

    public function testHeading1() {
        $markdown = "# Heading 1";
        $html = markdownToHTML($markdown);
        $this->assertEquals("<h1>Heading 1</h1>", $html);
    }

    public function testHeading2() {
        $markdown = "## Heading 2";
        $html = markdownToHTML($markdown);
        $this->assertEquals("<h2>Heading 2</h2>", $html);
    }

    public function testLink() {
        $markdown = "[Link text](https://www.example.com)";
        $html = markdownToHTML($markdown);
        $this->assertEquals('<a href="https://www.example.com">Link text</a>', $html);
    }

    public function testUnformattedText() {
        $markdown = "Unformatted text";
        $html = markdownToHTML($markdown);
        $this->assertEquals("<p>Unformatted text</p>", $html);
    }

    public function testBlankLine() {
        $markdown = "\n";
        $html = markdownToHTML($markdown);
        $this->assertEquals("", $html); // Depending on how your function handles blank lines, this assertion might need to be adjusted
    }
}
