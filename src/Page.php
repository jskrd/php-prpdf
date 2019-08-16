<?php

namespace Jskrd\PrintReadyPDF;

use Imagick;
use ImagickPixel;

final class Page
{
    private $document;

    private $image;

    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->document->addPage($this);

        $this->image = new Imagick();
        $this->image->newImage(
            $this->document->getBleedBoxResolutionX(),
            $this->document->getBleedBoxResolutionY(),
            new ImagickPixel('#FF00FF')
        );
        $this->image->setImageFormat('png');
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function getImage(): Imagick
    {
        return $this->image;
    }

    public function addImageLayer(string $image): Page
    {
        $imagick = new Imagick();
        $imagick->readImageBlob($image);

        $this->image->addImage($imagick);

        $this->image = $this->image->mergeImageLayers(
            Imagick::LAYERMETHOD_FLATTEN
        );

        return $this;
    }

    public function cropImageBleed(
        bool $top = true,
        bool $right = true,
        bool $bottom = true,
        bool $left = true
    ): Page {
        $bleedSize = self::millimeterToPixel(
            $this->document->getBleedSize() * 2,
            $this->document->getDotsPerCentimeter()
        );
        $bleedSize /= 2;

        $width  = $this->image->getImageWidth();
        $height = $this->image->getImageHeight();
        $x      = 0;
        $y      = 0;

        $x      += $left ? $bleedSize : 0;
        $y      += $top ? $bleedSize : 0;
        $width  -= $right ? $bleedSize + $x : 0;
        $height -= $bottom ? $bleedSize + $y : 0;

        $this->image->cropImage($width, $height, $x, $y);

        return $this;
    }

    public function render(): string
    {
        $this->image->stripImage();

        return $this->image->getImageBlob();
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
