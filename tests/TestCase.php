<?php

namespace Tests;

use Imagick;
use ImagickPixel;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function makeImage(int $width, int $height, string $color): string
    {
        $imagick = new Imagick();
        $imagick->newImage($width, $height, new ImagickPixel($color));
        $imagick->setImageFormat('png');

        return $imagick->getImageBlob();
    }
}
