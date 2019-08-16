<?php

namespace Jskrd\PrintReadyPDF;

use Imagick;
use ImagickPixel;

final class Page
{
    private $image;

    public function __construct(Document $document)
    {
        $width = $document->getBleedBoxResolutionX();
        $height = $document->getBleedBoxResolutionY();
        $dpcm = $document->getDotsPerCentimeter();

        $this->image = new Imagick();
        $this->image->newImage($width, $height, new ImagickPixel('#FF00FF'));
        $this->image->setImageUnits(Imagick::RESOLUTION_PIXELSPERCENTIMETER);
        $this->image->setImageResolution($dpcm, $dpcm);
    }

    public function getImage(): Imagick
    {
        return $this->image;
    }

    public function getImageWidth(): int
    {
        return $this->image->getImageWidth();
    }

    public function getImageHeight(): int
    {
        return $this->image->getImageHeight();
    }

    public function render(): string
    {
        $imagick = $this->image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $imagick->setImageFormat('png');
        $imagick->stripImage();

        return $imagick->getImageBlob();
    }

    public static function millimeterToCentimeter(float $mm): float
    {
        return round($mm * .1, 8);
    }

    public static function millimeterToInch(float $mm): float
    {
        return round($mm * .0393701, 8);
    }

    public static function millimeterToPixel(float $mm, float $dpcm): int
    {
        return round(self::millimeterToCentimeter($mm) * $dpcm);
    }

    public static function centimeterToMillimeter(float $cm): float
    {
        return round($cm * 10, 8);
    }

    public static function centimeterToInch(float $cm): float
    {
        return round($cm * .393701, 8);
    }

    public static function centimeterToPixel(float $cm, float $dpcm): int
    {
        return round($cm * $dpcm);
    }

    public static function inchToMillimeter(float $in): float
    {
        return round($in * 25.4, 8);
    }

    public static function inchToCentimeter(float $in): float
    {
        return round($in * 2.54, 8);
    }

    public static function inchToPixel(float $in, float $dpcm): int
    {
        return round(self::inchToCentimeter($in) * $dpcm);
    }
}
