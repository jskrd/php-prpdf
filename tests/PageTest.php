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
        $document = new Document(105, 148, 118.11023622);

        $page = new Page($document);

        $imagick = $page->getImage();

        $this->assertSame(1311, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());
        $this->assertSame(
            Imagick::RESOLUTION_PIXELSPERCENTIMETER,
            $imagick->getImageUnits()
        );
        $this->assertSame(
            ['x' => 118.11023622, 'y' => 118.11023622],
            $imagick->getImageResolution()
        );
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
            'c3ac3a44a893d742f946f4508397cdeb2733715e0d4cece696c430f37c14030e',
            hash('sha256', $page->render())
        );
    }

    public function testRender()
    {
        $document = new Document(105, 148, 118.11023622);

        $page = new Page($document);

        $this->assertSame(
            'ae17bb8b4112571ac679a5c62fbeb1aa9a479d6643d271d09ea7eb2144437c6e',
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
