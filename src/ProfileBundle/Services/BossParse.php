<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.06.15
 * Time: 14:11
 */

namespace ProfileBundle\Services;

class BossParse
{
    public function parse($filename, $fileMimType)
    {
        if ($fileMimType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
//                    dump('chmod o+r /var/www/aog-profile/web/'.$path['url']);exit;

//            $content = $this->get('parse_docx')->read_file_docx($filename);

            $content = new ParseDocxFile();
            $content->read_file_docx($filename);

        } elseif ($fileMimType == 'application/pdf') {

            $content = new ParsePdf();
//            dump($filename, $fileMimType);exit;
            $content->parse($filename);
            dump($content['parsepdf']);exit;
//            $content = $this->get('parse_pdf')->parse('/var/www/aog-profile/web/' . $filename);
//                    $parser = new \Smalot\PdfParser\Parser();
//                    $pdf    = $parser->parseFile('/var/www/aog-profile/web/'.$path['url']);
//
//                    $content = $pdf->getText();

        } else {
            $content = new ParseDoc();
            $content->parse($filename);
//            $content = $this->get('parse_doc')->parse('/var/www/aog-profile/web/' . $filename);
//                    $content = shell_exec('/usr/bin/antiword -m UTF-8.txt '.'chmod o+r /var/www/aog-profile/web/'.$path['url']);
        }
//        dump($content, $path['url'], $path, $data['photo']->getClientMimeType(), $data['photo']->getClientOriginalName());exit;
        return $content;

    }

}