<?php

namespace StorageBundle\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gaufrette\Filesystem;

class PhotoUploader
{
    private static $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf',
        'image/vnd.adobe.photoshop',
        'application/postscript',
        'application/postscript',
        'application/postscript',

        // ms office
        'application/msword',
        'application/rtf',
        'application/vnd.ms-excel',
        'application/vnd.ms-powerpoint',
        'application/msword',
        'application/vnd.ms-excel',
        'application/vnd.ms-powerpoint',
        // open office
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.spreadsheet',

        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.openxmlformats-officedocument.presentationml.template',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'application/vnd.ms-excel.addin.macroEnabled.12',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',

    );

    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file)
    {
        // Check if the file's mime type is in the list of allowed mime types.
        if (!in_array($file->getClientMimeType(), self::$allowedMimeTypes)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }


        // Generate a unique filename based on the date and add file extension of the uploaded file
        $filename = sprintf('%s/%s/%s/%s', date('Y'), date('m'), date('d'), $file->getClientOriginalName());

        $adapter = $this->filesystem->getAdapter();
        $adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function uploadUserName(UploadedFile $file, $entity_username)
    {
        // Check if the file's mime type is in the list of allowed mime types.
        if (!in_array($file->getClientMimeType(), self::$allowedMimeTypes)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }

        // Generate a unique filename based on the date and add file extension of the uploaded file
        $filename = sprintf('%s/%s/%s/%s.%s', date('Y'), date('m'), date('d'), $entity_username, $file->getClientOriginalExtension());

        $adapter = $this->filesystem->getAdapter();
        $adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function uploadFromUrl($url)
    {
        // Get file extension
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        // Generate a unique filename based on the date and add file extension of the uploaded file
        $filename = sprintf('%s/%s/%s/%s.%s', date('Y'), date('m'), date('d'), uniqid(), $extension);

        // Guess mime type
        $mimeType = $this->guessMimeType($extension);

        $adapter = $this->filesystem->getAdapter();

        $adapter->setMetadata($filename, array('contentType' => $mimeType));
        $adapter->write($filename, file_get_contents($url));

        return $filename;
    }

    public function uploadFromUrlName($url, $image_name)
    {
        // Get file extension
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        // Generate a unique filename based on the date and add file extension of the uploaded file
        $filename = sprintf('%s/%s/%s/%s.%s', date('Y'), date('m'), date('d'), $image_name, $extension);

        // Guess mime type
        $mimeType = $this->guessMimeType($extension);

        $adapter = $this->filesystem->getAdapter();

        $adapter->setMetadata($filename, array('contentType' => $mimeType));
        $adapter->write($filename, file_get_contents($url));

        return $filename;
    }

    private function guessMimeType($extension)
    {
        $mimeTypes = array(

            'txt'  => 'text/plain',
            'htm'  => 'text/html',
            'html' => 'text/html',
            'php'  => 'text/html',
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'swf'  => 'application/x-shockwave-flash',
            'flv'  => 'video/x-flv',

            // images
            'png'  => 'image/png',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif'  => 'image/tiff',
            'svg'  => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'exe'  => 'application/x-msdownload',
            'msi'  => 'application/x-msdownload',
            'cab'  => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3'  => 'audio/mpeg',
            'qt'   => 'video/quicktime',
            'mov'  => 'video/quicktime',

            // adobe
            'pdf'  => 'application/pdf',
            'psd'  => 'image/vnd.adobe.photoshop',
            'ai'   => 'application/postscript',
            'eps'  => 'application/postscript',
            'ps'   => 'application/postscript',

            // ms office
            'doc'  => 'application/msword',
            'rtf'  => 'application/rtf',
            'xls'  => 'application/vnd.ms-excel',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',

            // open office
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        if (array_key_exists($extension, $mimeTypes)) {
            return $mimeTypes[$extension];
        } else {
            return 'application/octet-stream';
        }

    }

}
