<?php

namespace Tests;

use Jskrd\PrintReadyPDF\Document;
use Jskrd\PrintReadyPDF\Page;

class DocumentTest extends TestCase
{
    public function testGetPageWidth()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(210.0, $document->getPageWidth());
    }

    public function testGetPageHeight()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(297.0, $document->getPageHeight());
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

    public function testSetBleedSize()
    {
        $document = (new Document(210, 297, 118.11023622))
            ->setBleedSize(20);

        $this->assertSame(20.0, $document->getBleedSize());
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

    public function testGetSlugSize()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(7, $document->getSlugSize());
    }

    public function testGetPaperWidth()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(224, $document->getPaperWidth());
    }

    public function testGetPaperHeight()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(311, $document->getPaperHeight());
    }

    public function testGetBleedBoxWidth()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(216.0, $document->getBleedBoxWidth());
    }

    public function testGetBleedBoxHeight()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(303.0, $document->getBleedBoxHeight());
    }

    public function testGetBleedBoxResolutionX()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(2551, $document->getBleedBoxResolutionX());
    }

    public function testGetBleedBoxResolutionY()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame(3579, $document->getBleedBoxResolutionY());
    }

    public function testGetPages()
    {
        $document = new Document(210, 297, 118.11023622);

        $this->assertSame([], $document->getPages());
    }

    public function testAddPage()
    {
        $page = new Page;

        $document = (new Document(210, 297, 118.11023622))
            ->addPage($page);

        $this->assertSame([$page], $document->getPages());
    }

    public function testMillimeterToCentimeter()
    {
        $this->assertSame(.1, Document::millimeterToCentimeter(1));
    }

    public function testMillimeterToInch()
    {
        $this->assertSame(.0393701, Document::millimeterToInch(1));
    }

    public function testMillimeterToPixel()
    {
        $this->assertSame(12, Document::millimeterToPixel(1, 118.11023622));
    }

    public function testCentimeterToMillimeter()
    {
        $this->assertSame(10.0, Document::centimeterToMillimeter(1));
    }

    public function testCentimeterToInch()
    {
        $this->assertSame(0.393701, Document::centimeterToInch(1));
    }

    public function testCentimeterToPixel()
    {
        $this->assertSame(118, Document::centimeterToPixel(1, 118.11023622));
    }

    public function testInchToMillimeter()
    {
        $this->assertSame(25.4, Document::inchToMillimeter(1));
    }

    public function testInchToCentimeter()
    {
        $this->assertSame(2.54, Document::inchToCentimeter(1));
    }

    public function testInchToPixel()
    {
        $this->assertSame(300, Document::inchToPixel(1, 118.11023622));
    }
}
