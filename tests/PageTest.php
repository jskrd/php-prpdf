<?php

namespace Tests;

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

    public function testMillimeterToCentimeter()
    {
        $this->assertSame(.1, Page::millimeterToCentimeter(1));
    }

    public function testMillimeterToInch()
    {
        $this->assertSame(.0393701, Page::millimeterToInch(1));
    }

    public function testMillimeterToPixel()
    {
        $this->assertSame(12, Page::millimeterToPixel(1, 118.11023622));
    }

    public function testCentimeterToMillimeter()
    {
        $this->assertSame(10.0, Page::centimeterToMillimeter(1));
    }

    public function testCentimeterToInch()
    {
        $this->assertSame(0.393701, Page::centimeterToInch(1));
    }

    public function testCentimeterToPixel()
    {
        $this->assertSame(118, Page::centimeterToPixel(1, 118.11023622));
    }

    public function testInchToMillimeter()
    {
        $this->assertSame(25.4, Page::inchToMillimeter(1));
    }

    public function testInchToCentimeter()
    {
        $this->assertSame(2.54, Page::inchToCentimeter(1));
    }

    public function testInchToPixel()
    {
        $this->assertSame(300, Page::inchToPixel(1, 118.11023622));
    }
}
