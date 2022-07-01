<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{

    public function __construct()
    {
        $this->number_of_books = 0;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $full_name;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $number_of_books;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getNumberOfBooks(): ?int
    {
        return $this->number_of_books;
    }

    public function setNumberOfBooks(string $number_of_books): self
    {
        $this->number_of_books = $number_of_books;

        return $this;
    }

}
