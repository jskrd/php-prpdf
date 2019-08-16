<?php

namespace Tests;

use Imagick;
use Jskrd\PrintReadyPDF\Document;
use Jskrd\PrintReadyPDF\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testGetDocument()
    {
        $document = new Document(105, 148, 118.11023622);

        $page = new Page($document);

        $this->assertSame($document, $page->getDocument());
    }

    public function testGetImage()
    {
        $document = new Document(105, 148, 118.11023622);

        $page = new Page($document);

        $imagick = $page->getImage();

        $this->assertSame(1311, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());
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

    public function testCropImageBleed()
    {
        $document = new Document(105, 148, 118.11023622);

        $background = file_get_contents(__DIR__ . '/assets/background.png');
        $border = file_get_contents(__DIR__ . '/assets/border.png');

        $page = (new Page($document))
            ->addImageLayer($background)
            ->addImageLayer($border)
            ->cropImageBleed();

        $imagick = $page->getImage();

        $this->assertSame(1240, $imagick->getImageWidth());
        $this->assertSame(1748, $imagick->getImageHeight());

        $this->assertSame(
            'fc974552f34742541a91b1fade0212d99f2e534e06c7f0b4aeed8d402dac6f83',
            hash('sha256', $page->render())
        );
    }

    public function testCropImageBleedOnlyTop()
    {
        $document = new Document(105, 148, 118.11023622);

        $background = file_get_contents(__DIR__ . '/assets/background.png');
        $border = file_get_contents(__DIR__ . '/assets/border.png');

        $page = (new Page($document))
            ->addImageLayer($background)
            ->addImageLayer($border)
            ->cropImageBleed(true, false, false, false);

        $imagick = $page->getImage();

        $this->assertSame(1311, $imagick->getImageWidth());
        $this->assertSame(1784, $imagick->getImageHeight());

        $this->assertSame(
            'f8571785ae2b822dfb9ea388f27f5e8b6d67fb94d0b54bc31fc1581f1364bcbe',
            hash('sha256', $page->render())
        );
    }

    public function testCropImageBleedOnlyRight()
    {
        $document = new Document(105, 148, 118.11023622);

        $background = file_get_contents(__DIR__ . '/assets/background.png');
        $border = file_get_contents(__DIR__ . '/assets/border.png');

        $page = (new Page($document))
            ->addImageLayer($background)
            ->addImageLayer($border)
            ->cropImageBleed(false, true, false, false);

        $imagick = $page->getImage();

        $this->assertSame(1275, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());

        $this->assertSame(
            'cb6d266e91a10c6809685ad71f857269cbc72f40990ea318a71e63e95a737941',
            hash('sha256', $page->render())
        );
    }

    public function testCropImageBleedOnlyBottom()
    {
        $document = new Document(105, 148, 118.11023622);

        $background = file_get_contents(__DIR__ . '/assets/background.png');
        $border = file_get_contents(__DIR__ . '/assets/border.png');

        $page = (new Page($document))
            ->addImageLayer($background)
            ->addImageLayer($border)
            ->cropImageBleed(false, false, true, false);

        $imagick = $page->getImage();

        $this->assertSame(1311, $imagick->getImageWidth());
        $this->assertSame(1783, $imagick->getImageHeight());

        $this->assertSame(
            'b6089596680020f52f786469c98d79843b09f529a98ae123df52dae7d0e5de5b',
            hash('sha256', $page->render())
        );
    }

    public function testCropImageBleedOnlyLeft()
    {
        $document = new Document(105, 148, 118.11023622);

        $background = file_get_contents(__DIR__ . '/assets/background.png');
        $border = file_get_contents(__DIR__ . '/assets/border.png');

        $page = (new Page($document))
            ->addImageLayer($background)
            ->addImageLayer($border)
            ->cropImageBleed(false, false, false, true);

        $imagick = $page->getImage();

        $this->assertSame(1276, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());

        $this->assertSame(
            'df8fe9809c5029a233b24d831d11b4266331cac0b3af02289cda3a0504029451',
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
