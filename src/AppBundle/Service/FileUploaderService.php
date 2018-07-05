<?php
/**
 * FileUploader Service File
 *
 * PHP version 7.1
 *
 * @category FileUploaderServiceService
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileUploader class service.
 *
 * @category FileUploaderServiceService
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class FileUploaderService
{
    private $_targetDirectory;

    private $_nameCanonical;

    /**
     * FileUploaderService constructor.
     *
     * @param string $targetDirectory path to pdf directory constant in config.yml
     */
    public function __construct($targetDirectory)
    {
        $this->_targetDirectory = $targetDirectory;
    }

    /**
     * Uploader file
     *
     * @param UploadedFile $file           get name of the upload file in db
     * @param int          $organizationId organization 's id
     * @param int          $activityId     activity 's id
     * @param null|int     $offerId        offer 's id
     *
     * @return string
     */
    public function upload(UploadedFile $file, $organizationId,
        $activityId, $offerId = null
    ) {
        $fileName = $this->setNameCanonical(
            $file->getClientOriginalExtension(), $file->getClientOriginalName()
        ) . '_' . md5(uniqid()) . '.' . $file->guessExtension();

        $file->move(
            $this->getTargetDirectory(
                $organizationId,
                $activityId,
                $offerId
            ),
            $fileName
        );

        return $fileName;
    }

    /**
     * Path to pdf directory
     *
     * @param int  $organizationId organization 's id
     * @param int  $activityId     activity 's id
     * @param null $offerId        offer 's id
     *
     * @return string
     */
    public function getTargetDirectory($organizationId, $activityId, $offerId = null)
    {
        $offerDir = $offerId != null ? '/offer_'.$offerId : null;

        return $this->_targetDirectory.
            '/organization_'.$organizationId.
            '/activity_'.$activityId.$offerDir;
    }

    /**
     * NameCanonical to supp extension and underscore to file name
     *
     * @param string $extension    extension of the file
     * @param string $originalName original name with extension to the file
     *
     * @return string
     */
    public function setNameCanonical($extension, $originalName)
    {
        $originalName = str_replace('.' . $extension, '', $originalName);

        return $this->_nameCanonical = strtolower(
            str_replace(' ', '_', $originalName)
        );

    }
}