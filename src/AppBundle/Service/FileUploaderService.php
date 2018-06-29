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
    /**
     * Uploader for Galibelum
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
        $path = '/../../../web/uploads/pdf/'.'/organization_'.$organizationId.'/activity';

        // Check if the directory exist and create if no
        if (!file_exists(__DIR__ .$path)) {
            mkdir(__DIR__ .$path, 0777, true);
            $file->move(__DIR__ .$path, $fileName);
        } else {
            $file->move(__DIR__ .$path, $fileName);
        }

        return $fileName;
    }
}