<?php
/**
 * FileUploader Service File
 *
 * PHP version 7.1
 *
 * @category Service
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileUploader class service.
 *
 * @category Service
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class FileUploaderService
{
    private $_targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->_targetDirectory = $targetDirectory;
    }

    /**
     * Uploader for file
     *
     * @param UploadedFile $file           get name of the upload file in db
     * @param int          $id             extension of the file's name
     * @param int          $organizationId extension of the directory's name
     *
     * @return string
     */
    public function upload(UploadedFile $file, $id, $organizationId)
    {
        $fileName = 'activity_'.$id.'.'.$file->guessExtension();
        $path = $this->getTargetDirectory().'/organization_'.$organizationId.'/activity';

        // Check if the directory exist and create if no
        if (!file_exists($path)) {
            $file->move( $path, $fileName);
        } else {
            $file->move($path, $fileName);
        }
        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->_targetDirectory;
    }
}