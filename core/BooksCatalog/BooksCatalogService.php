<?php

declare(strict_types=1);

namespace Core\BooksCatalog;

use Core\BooksCatalog\Author\Events\AuthorWasDeleted;
use Core\BooksCatalog\Author\IRepository as IRepositoryAuthor;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Events\BookWasDeleted;
use Core\BooksCatalog\Book\IRepository;
use Core\BooksCatalog\Book\Props\BookId;
use Core\Common\Event\Events;

final class BooksCatalogService
{
    use Events;

    private IRepositoryAuthor $authorRepo;
    private IRepository $bookRepo;

    public function __construct(IRepositoryAuthor $authorRepo, IRepository $bookRepo)
    {
        $this->authorRepo = $authorRepo;
        $this->bookRepo = $bookRepo;
    }

    public function deleteAuthor(AuthorId $id): void
    {
        // Удаление книг автора выполняет хранилище каскадным удалением.
        $this->authorRepo->delete($id);
        $this->addEvent(new AuthorWasDeleted($id));

    }

    public function deleteBook(BookId $id): void
    {
        $this->bookRepo->delete($id);
        $this->addEvent(new BookWasDeleted($id));
    }
}
