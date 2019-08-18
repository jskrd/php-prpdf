<?php

namespace Tests;

use Imagick;
use ImagickPixel;
use Jskrd\PrintReadyPDF\Document;
use Jskrd\PrintReadyPDF\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testGetImages()
    {
        $page = new Page;

        $this->assertSame([], $page->getImages());
    }

    public function testAddImage()
    {
        $image = $this->makeImage(1311, 1819, '#FFFFFF');

        $page = (new Page)->addImage($image);

        $this->assertSame([$image], $page->getImages());
    }

    public function testRenderSingle()
    {
        $page = (new Page)->addImage($this->makeImage(1311, 1819, '#FFAAAA'));

        $imagick = new Imagick();
        $imagick->readImageBlob($page->render());

        $this->assertSame(1311, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());
        $this->assertSame(
            ['r' => 255, 'g' => 170, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(0, 0)->getColor()
        );
        $this->assertSame(
            ['r' => 255, 'g' => 170, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(1310, 1818)->getColor()
        );
    }

    public function testRenderDouble()
    {
        $page = (new Page)
            ->addImage($this->makeImage(1276, 1819, '#AAFFAA'))
            ->addImage($this->makeImage(1276, 1819, '#FFAAAA'));

        $imagick = new Imagick();
        $imagick->readImageBlob($page->render());

        $this->assertSame(2552, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());
        $this->assertSame(
            ['r' => 170, 'g' => 255, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(0, 0)->getColor()
        );
        $this->assertSame(
            ['r' => 170, 'g' => 255, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(1275, 1818)->getColor()
        );
        $this->assertSame(
            ['r' => 255, 'g' => 170, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(1276, 0)->getColor()
        );
        $this->assertSame(
            ['r' => 255, 'g' => 170, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(2551, 1818)->getColor()
        );
    }

    public function testRenderSpine()
    {
        $page = (new Page)
            ->addImage($this->makeImage(1276, 1819, '#AAFFAA'))
            ->addImage($this->makeImage(118, 1819, '#AAAAFF'))
            ->addImage($this->makeImage(1276, 1819, '#FFAAAA'));

        $imagick = new Imagick();
        $imagick->readImageBlob($page->render());

        $this->assertSame(2670, $imagick->getImageWidth());
        $this->assertSame(1819, $imagick->getImageHeight());
        $this->assertSame(
            ['r' => 170, 'g' => 255, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(0, 0)->getColor()
        );
        $this->assertSame(
            ['r' => 170, 'g' => 255, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(1275, 1818)->getColor()
        );
        $this->assertSame(
            ['r' => 170, 'g' => 170, 'b' => 255, 'a' => 1],
            $imagick->getImagePixelColor(1276, 0)->getColor()
        );
        $this->assertSame(
            ['r' => 170, 'g' => 170, 'b' => 255, 'a' => 1],
            $imagick->getImagePixelColor(1393, 1818)->getColor()
        );
        $this->assertSame(
            ['r' => 255, 'g' => 170, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(1394, 0)->getColor()
        );
        $this->assertSame(
            ['r' => 255, 'g' => 170, 'b' => 170, 'a' => 1],
            $imagick->getImagePixelColor(2669, 1818)->getColor()
        );
    }

    private function makeImage(int $width, int $height, string $color): string
    {
        $imagick = new Imagick();
        $imagick->newImage($width, $height, new ImagickPixel($color));
        $imagick->setImageFormat('png');

        return $imagick->getImageBlob();
    }
}
