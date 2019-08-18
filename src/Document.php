<?php

namespace Jskrd\PrintReadyPDF;

use Dompdf\Dompdf;
use Jskrd\PrintReadyPDF\Page;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class Document
{
    private $pageWidth; // mm

    private $pageHeight; // mm

    private $dotsPerCentimeter;

    private $bleedSize = 3; // mm

    private $cropMarksLength = 5; // mm

    private $cropMarksWeight = .1; // mm

    private $cropMarksOffset = 2; // mm

    private $pages = [];

    public function __construct(int $pageWidth, int $pageHeight, float $dpcm)
    {
        $this->pageWidth = $pageWidth;
        $this->pageHeight = $pageHeight;
        $this->dotsPerCentimeter = $dpcm;
    }

    public function getPageWidth(): int
    {
        return $this->pageWidth;
    }

    public function getPageHeight(): int
    {
        return $this->pageHeight;
    }

    public function getDotsPerCentimeter(): float
    {
        return $this->dotsPerCentimeter;
    }

    public function getDotsPerMillimeter(): float
    {
        return round($this->getDotsPerCentimeter() * .1, 8);
    }

    public function getDotsPerInch(): float
    {
        return round($this->getDotsPerCentimeter() * 2.54, 8);
    }

    public function getBleedSize(): float
    {
        return $this->bleedSize;
    }

    public function getCropMarksLength(): float
    {
        return $this->cropMarksLength;
    }

    public function getCropMarksWeight(): float
    {
        return $this->cropMarksWeight;
    }

    public function getCropMarksOffset(): float
    {
        return $this->cropMarksOffset;
    }

    public function getSlugSize(): int
    {
        $cropMarks = $this->getCropMarksOffset() + $this->getCropMarksLength();
        $bleed = $this->getBleedSize();

        return ceil($cropMarks > $bleed ? $cropMarks : $bleed);
    }

    public function getPaperWidth(): int
    {
        return $this->getPageWidth() + $this->getSlugSize() * 2;
    }

    public function getPaperHeight(): int
    {
        return $this->getPageHeight() + $this->getSlugSize() * 2;
    }

    public function getBleedBoxWidth(): float
    {
        return $this->getPageWidth() + $this->getBleedSize() * 2;
    }

    public function getBleedBoxHeight(): float
    {
        return $this->getPageHeight() + $this->getBleedSize() * 2;
    }

    public function getBleedBoxResolutionX(): int
    {
        return round(
            $this->getBleedBoxWidth() * $this->getDotsPerMillimeter()
        );
    }

    public function getBleedBoxResolutionY(): int
    {
        return round(
            $this->getBleedBoxHeight() * $this->getDotsPerMillimeter()
        );
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function addPage(Page $page): Document
    {
        $this->pages[] = $page;

        return $this;
    }

    public function render(): string
    {
        $images = [];
        foreach ($this->getPages() as $page)
            $images[] = base64_encode($page->render());

        $twig = new Environment(new FilesystemLoader(__DIR__ . '/Templates'));

        $dompdf = new Dompdf();
        $dompdf->set_option('dpi', $this->getDotsPerInch());
        $dompdf->loadHtml(
            $twig->render('document.html', [
                'pageWidth' => $this->getPageWidth(),
                'pageHeight' => $this->getPageHeight(),
                'paperWidth' => $this->getPaperWidth(),
                'paperHeight' => $this->getPaperHeight(),
                'cropMarksLength' => $this->getCropMarksLength(),
                'cropMarksWeight' => $this->getCropMarksWeight(),
                'cropMarksOffset' => $this->getCropMarksOffset(),
                'images' => $images
            ])
        );
        $dompdf->render();

        return $dompdf->output();
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
