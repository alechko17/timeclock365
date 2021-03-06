<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\AuthorGallery;
use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\AuthorGalleryRepository;
use App\Repository\AuthorRepository;
use App\Repository\BooksRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("/", name="app_books_index", methods={"GET"})
     */
    public function index(BooksRepository $booksRepository): Response
    {
        return $this->render('books/index.html.twig', [
            'books' => $booksRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_books_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BooksRepository $booksRepository, AuthorGalleryRepository $authorGalleryRepository, FileUploader $fileUploader): Response
    {
        $book = new Books();

        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $coverFile = $form->get('cover')->getData();

            if ($coverFile) {
                $coverFileName = $fileUploader->upload($coverFile);
                $book->setCoverFilename($coverFileName);
            }

            $booksRepository->add($book);

            $authorGallery = new AuthorGallery();
            $authorGallery->setBookId($book->getId());
            $authorGallery->setAuthoreId($request->get('author'));

            $authorGalleryRepository->add($authorGallery);

            return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
        }

        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();

        return $this->render('books/new.html.twig', [
            'authors' => $authors,
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_books_show", methods={"GET"})
     */
    public function show(Books $book): Response
    {
        return $this->render('books/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_books_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Books $book, BooksRepository $booksRepository, AuthorGalleryRepository $authorGalleryRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $coverFile = $form->get('cover')->getData();

            if ($coverFile) {
                $coverFileName = $fileUploader->upload($coverFile);
                $book->setCoverFilename($coverFileName);
            }

            $booksRepository->add($book);

            $authorGallery = new AuthorGallery();
            $authorGallery->setBookId($book->getId());
            $authorGallery->setAuthoreId($request->get('author'));

            $authorGalleryRepository->add($authorGallery);

            return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
        }

        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();

        return $this->render('books/edit.html.twig', [
            'authors' => $authors,
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_books_delete", methods={"POST"})
     */
    public function delete(Request $request, Books $book, BooksRepository $booksRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $booksRepository->remove($book);
        }

        return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
    }
}
