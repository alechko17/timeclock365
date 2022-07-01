<?php

namespace App\EventListener;

use App\Entity\Author;
use App\Entity\AuthorGallery;
use App\Repository\AuthorGalleryRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Persistence\ManagerRegistry;

//use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class AuthorBooksUpdater
{
    public function postPersist( LifecycleEventArgs $args )
    {
        $entity = $args->getObject();

        // only act on some "AuthorGallery" entity
        if (!$entity instanceof AuthorGallery) {
            return;
        }

        $entityManager = $args->getObjectManager();

        $entityManager->getRepository(\App\Entity\Author::class)->incrementBooksCount($entity->getAuthoreId());

    }
}