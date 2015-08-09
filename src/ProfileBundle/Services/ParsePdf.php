<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.06.15
 * Time: 14:01
 */

namespace ProfileBundle\Services;

class ParsePdf
{
    public function parse($filename)
    {
//        dump($filename);exit;
        $parser = new \Smalot\PdfParser\Parser();
        $pdf    = $parser->parseFile($filename);

        $content = $pdf->getText();
//        dump($content);exit;
        return $content;
    }

}