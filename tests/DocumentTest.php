<?php

use Jskrd\PrintReadyPDF\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testGetPageWidth()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(210, $document->getPageWidth());
    }

    public function testGetPageHeight()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(297, $document->getPageHeight());
    }

    public function testGetDotsPerCentimeter()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(118.11023622, $document->getDotsPerCentimeter());
    }

    public function testGetDotsPerMillimeter()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(11.81102362, $document->getDotsPerMillimeter());
    }

    public function testGetDotsPerInch()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(300.0, $document->getDotsPerInch());
    }

    public function testGetBleedSize()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(3.0, $document->getBleedSize());
    }

    public function testGetCropMarksLength()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(5.0, $document->getCropMarksLength());
    }

    public function testGetCropMarksWeight()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(.1, $document->getCropMarksWeight());
    }

    public function testGetCropMarksOffset()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(2.0, $document->getCropMarksOffset());
    }
}
