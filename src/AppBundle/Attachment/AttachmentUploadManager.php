<?php

namespace AppBundle\Attachment;

use AppBundle\Entity\Attachment;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class AttachmentStorageManager
 */
class AttachmentUploadManager
{
    /** @var  string */
    private $uploadDirPath;

    /**
     * @param string $uploadDirPath
     */
    public function __construct($uploadDirPath)
    {
        $this->uploadDirPath = $uploadDirPath;
    }


    public function upload(Attachment $attachment)
    {
        $file = $attachment->getFile();
        if (null === $file) {
            return;
        }

        $hashedFileName = md5(uniqid($file->getClientOriginalName()));
        $newFileNameWithExtension = $hashedFileName . "." .$file->getClientOriginalExtension();

        try {
            $file->move($this->uploadDirPath, $newFileNameWithExtension);
        } catch (FileException $e) {
            // you should log this

            return;
        }

        $attachment->setFilename($newFileNameWithExtension);
        $attachment->setOriginalFileName($file->getClientOriginalName());
    }
}
