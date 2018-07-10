<?php

/**
 * Event Listener file
 *
 * PHP version 7.2
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\EventListener;

use AppBundle\Entity\Organization;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Activity;
use AppBundle\Service\FileUploaderService;

/**
 * FileUploadListener class.
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class FileUploadListener
{
    private $_uploader;

    /**
     * FileUploadListener constructor.
     *
     * @param FileUploaderService $_uploader Uploader to upload
     */
    public function __construct(FileUploaderService $_uploader)
    {
        $this->_uploader = $_uploader;
    }

    /**
     * FileUploadListener constructor.
     *
     * @param LifecycleEventArgs $args prePersist
     *
     * @return string
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->_uploadFile($entity);
    }

    /**
     * FileUploadListener constructor.
     *
     * @param PreUpdateEventArgs $args preUpdate
     *
     * @return string
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->_uploadFile($entity);
    }

    /**
     * FileUploadListener constructor.
     *
     * @param Entity $entity UploadFile
     *
     * @return void
     */
    private function _uploadFile($entity)
    {
        // upload only works for Activity entities
        if (!$entity instanceof Activity) {
            return;
        }

        $file = $entity->getUploadPdf();
        $organizationId = $entity->getOrganizationActivities()->getId();
        $activityId = $entity->getId();

        // only upload new files
        if ($file instanceof UploadedFile
            && $organizationId instanceof Organization
            && $activityId instanceof Activity
        ) {
            $fileName = $this->_uploader->upload(
                $file, $organizationId, $activityId
            );
            $entity->setUploadPdf($fileName);
        }
    }
}