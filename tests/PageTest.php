<?php

namespace Tests;

use Imagick;
use Jskrd\PrintReadyPDF\Document;
use Jskrd\PrintReadyPDF\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testGetImage()
    {
        $document = new Document(210, 297, 118.11023622);

        $page = new Page($document);

        $imagick = $page->getImage();

        $this->assertSame(2551, $imagick->getImageWidth());
        $this->assertSame(3579, $imagick->getImageHeight());
        $this->assertSame(
            Imagick::RESOLUTION_PIXELSPERCENTIMETER,
            $imagick->getImageUnits()
        );
        $this->assertSame(
            ['x' => 118.11023622, 'y' => 118.11023622],
            $imagick->getImageResolution()
        );
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

    public function testAddLayerImage()
    {
        $document = new Document(105, 148, 118.11023622);

        $background = file_get_contents(__DIR__ . '/assets/background.png');
        $border = file_get_contents(__DIR__ . '/assets/border.png');

        $page = (new Page($document))
            ->addImageLayer($background)
            ->addImageLayer($border);

        $this->assertSame(
            '65a3a68ba6f475abc4855152a33518f099908d1eb3cf4f37a4447b307001cf7d',
            hash('sha256', $page->render())
        );
    }

    public function testRender()
    {
        $document = new Document(105, 148, 118.11023622);

        $page = new Page($document);

        $this->assertSame(
            '4a4e4fcde45556f889e67d039013542e8a0f500dd89b608a0b6e8f11565b39ed',
            hash('sha256', $page->render())
        );
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
