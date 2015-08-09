<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.06.15
 * Time: 14:06
 */

namespace ProfileBundle\Services;

class ParseDoc
{
    public function parse($filename)
    {
        $content = shell_exec('/usr/bin/antiword -m UTF-8.txt '.'chmod o+r '.$filename);

        return $content;
    }

}