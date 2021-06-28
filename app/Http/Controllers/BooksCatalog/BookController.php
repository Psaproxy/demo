<?php

namespace App\Http\Controllers\BooksCatalog;

use App\Events\WebSocketTest;
use App\Http\Controllers\Controller;
use Core\BooksCatalog\Author\Actions\ListAllNames;
use Core\BooksCatalog\Book\Actions\Add;
use Core\BooksCatalog\Book\Actions\Delete;
use Core\BooksCatalog\Book\Actions\Get;
use Core\BooksCatalog\Book\Actions\ListAll;
use Core\BooksCatalog\Book\Actions\Update;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookController extends Controller
{
    private ListAll $listAll;
    private Add $add;
    private ListAllNames $listAllAuthorsNames;
    private Delete $delete;
    private Get $get;
    private Update $update;

    public function __construct(
        ListAll $listAll,
        Add $add,
        ListAllNames $listAllAuthorsNames,
        Delete $delete,
        Get $get,
        Update $update
    )
    {
        $this->listAll = $listAll;
        $this->add = $add;
        $this->listAllAuthorsNames = $listAllAuthorsNames;
        $this->delete = $delete;
        $this->get = $get;
        $this->update = $update;
    }

    public function list(): View
    {
        $books = $this->listAll->execute();

        return view('books-catalog.book.list', compact('books'));
    }

    public function adding(): View
    {
        $authors = $this->listAllAuthorsNames->execute();

        return view('books-catalog.book.add', compact('authors'));
    }

    /**
     * @throws \Throwable
     * @noinspection PhpUndefinedFieldInspection
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'author_id' => 'required|string|exists:books_authors,id',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')
                    ->where('author_id', $request->author_id)
                    ->where('title', $request->title),
            ],
        ]);

        $this->add->execute($request->author_id, $request->title);

        $request->session()->push(
            'flash_massages',
            [
                'level' => 'success',
                'content' => __('books.successfully_added'),
            ],
        );

        return redirect()->route('books.list');
    }

    /**
     * @throws \Throwable
     */
    public function delete(Request $request): RedirectResponse
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $this->delete->execute($request->id);

        $request->session()->push(
            'flash_massages',
            [
                'level' => 'success',
                'content' => __('books.successfully_deleted'),
            ],
        );

        return redirect()->route('books.list');
    }

    /** @noinspection PhpUndefinedFieldInspection */
    public function editing(Request $request): View
    {
        $book = $this->get->execute($request->id);
        $authors = $this->listAllAuthorsNames->execute();

        return view('books-catalog.book.editing', compact('book', 'authors'));
    }

    /** @noinspection PhpUndefinedFieldInspection */
    /**
     * @throws \Throwable
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|string|exists:books,id',
            'author_id' => 'required|string|exists:books_authors,id',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')
                    ->where('author_id', $request->author_id)
                    ->where('title', $request->title),
            ],
        ]);

        $this->update->execute($request->id, $request->author_id, $request->title);

        $request->session()->push(
            'flash_massages',
            [
                'level' => 'success',
                'content' => __('books.successfully_updated'),
            ],
        );

        return redirect()->route('books.list');
    }
}
