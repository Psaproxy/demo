<?php

declare(strict_types=1);

namespace App\Infrastructure\MySql\Repository\BooksCatalog\Author;

use App\Models\BookAuthor as BookAuthorModel;
use Core\BooksCatalog\Author\IDataProvider;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\Props\Name;
use Core\BooksCatalog\Author\View\AuthorDTO;
use Illuminate\Support\Facades\DB;

class DataProvider implements IDataProvider
{
    private DataConverter $converter;

    public function __construct(DataConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @throws \Throwable
     */
    public function get(AuthorId $id): AuthorDTO
    {
        return $this->converter->toDTO(
            BookAuthorModel::findOrFail($id->value())
        );
    }

    /**
     * @return AuthorDTO[]
     */
    public function all(string $sortBy = ''): array
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->converter->toDTOs(
            ...BookAuthorModel::all()->sortBy($sortBy)
        );
    }

    /**
     * @return AuthorDTO[]
     */
    public function allWithSortingByName(): array
    {
        return $this->all('name');
    }

    /**
     * @return Name[]
     */
    public function allNames(): array
    {
        $names = DB::table('books_authors')
            ->select('id', 'name')
            ->get()
            ->toArray();

        return $this->converter->namesToDTOs(...$names);
    }
}
