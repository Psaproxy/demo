<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Actions;

use Core\BooksCatalog\Author\IDataProvider;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\View\AuthorDTO;

class Get
{
    private IDataProvider $dataProvider;

    public function __construct(IDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function execute(string $id): AuthorDTO
    {
        return $this->dataProvider->get(new AuthorId($id));
    }
}
