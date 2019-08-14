<?php

use Jskrd\PrintReadyPDF\Document;
use Jskrd\PrintReadyPDF\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testGetImage()
    {
        $document = new Document(210, 297, 118.11023622);

        $page = new Page($document);

        $this->assertSame('Imagick', get_class($page->getImage()));
    }

    public function testGetImageWidth()
    {
        $document = new Document(210, 297, 118.11023622);

        $page = new Page($document);

        $this->assertSame(2551, $page->getImageWidth());
    }

    public function testGetImageHeight()
    {
        $document = new Document(210, 297, 118.11023622);

        $page = new Page($document);

        $this->assertSame(3579, $page->getImageHeight());
    }
}
