<?php

namespace Jskrd\PrintReadyPDF;

use Imagick;

final class Page
{
    private $image;

    public function __construct(Document $document)
    {
        $this->image = new Imagick();
        $this->image->newImage(
            $document->getBleedBoxResolutionX(),
            $document->getBleedBoxResolutionY(),
            '#FF00FF'
        );
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
}
