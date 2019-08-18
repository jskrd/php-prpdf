<?php

namespace Jskrd\PrintReadyPDF;

use Imagick;
use Jskrd\PrintReadyPDF\Document;

final class Page
{
    private $images = [];

    public function getImages(): array
    {
        return $this->images;
    }

    public function addImage(string $image): Page
    {
        $this->images[] = $image;

        return $this;
    }

    public function render(): string
    {
        $imagick = new Imagick();

        foreach ($this->getImages() as $image)
            $imagick->readImageBlob($image);

        $imagick->resetIterator();
        $spread = $imagick->appendImages(false);

        $spread->setImageFormat('png');
        $spread->stripImage();

        return $spread->getImageBlob();
    }
}
