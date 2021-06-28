<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Actions;

use Core\BooksCatalog\Author\IDataProvider;
use Core\BooksCatalog\Author\View\NameDTO;

class ListAllNames
{
    private IDataProvider $dataProvider;

    public function __construct(IDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @return NameDTO[]
     */
    public function execute(): array
    {
        return $this->dataProvider->allNames();
    }
}
