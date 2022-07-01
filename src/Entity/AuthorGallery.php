<?php

namespace App\Entity;

use App\Repository\AuthorGalleryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorGalleryRepository::class)
 */
class AuthorGallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $authore_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $book_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthoreId(): ?int
    {
        return $this->authore_id;
    }

    public function setAuthoreId(int $authore_id): self
    {
        $this->authore_id = $authore_id;

        return $this;
    }

    public function getBookId(): ?int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): self
    {
        $this->book_id = $book_id;

        return $this;
    }
}
