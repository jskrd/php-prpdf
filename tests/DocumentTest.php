<?php

namespace Tests;

use Jskrd\PrintReadyPDF\Document;
use Jskrd\PrintReadyPDF\Page;
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
        $document = new Document(210, 297, 118.11023622);

        $page = new Page($document);

        $document->addPage($page);

        $this->assertSame([$page], $document->getPages());
    }
}
