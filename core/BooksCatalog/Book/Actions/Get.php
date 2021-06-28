<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Actions;

use Core\BooksCatalog\Book\IDataProvider;
use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\View\BookDTO;

class Get
{
    private IDataProvider $dataProvider;

    public function __construct(IDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function execute(string $id): BookDTO
    {
        return $this->dataProvider->get(new BookId($id));
    }
}
