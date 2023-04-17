<?php
namespace Otopix\Service;

use Otopix\Model\Article;
use Otopix\Model\ArticlePdf;
use Otopix\Model\ExamplePdf;

class PdfService
{
    public function getExamplePdf(): ExamplePdf
    {
        return new ExamplePdf();
    }

    public function getArticlePdf(Article $oArticle): ArticlePdf
    {
        return new ArticlePdf($oArticle);
    }
}
