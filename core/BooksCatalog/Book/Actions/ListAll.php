<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Actions;

use Core\BooksCatalog\Book\IDataProvider;
use Core\BooksCatalog\Book\View\BookDTO;

class ListAll
{
    private IDataProvider $dataProvider;

    public function __construct(IDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @return BookDTO[]
     */
    public function execute(): array
    {
        return $this->dataProvider->allWithSortingByTitle();
    }
}
