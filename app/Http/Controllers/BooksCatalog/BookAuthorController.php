<?php

namespace App\Http\Controllers\BooksCatalog;

use App\Http\Controllers\Controller;
use Core\BooksCatalog\Author\Actions\Add;
use Core\BooksCatalog\Author\Actions\Delete;
use Core\BooksCatalog\Author\Actions\Get;
use Core\BooksCatalog\Author\Actions\ListAll;
use Core\BooksCatalog\Author\Actions\Update;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookAuthorController extends Controller
{
    private ListAll $listAll;
    private Add $add;
    private Delete $delete;
    private Get $get;
    private Update $update;

    public function __construct(ListAll $listAll, Add $add, Delete $delete, Get $get, Update $update)
    {
        $this->listAll = $listAll;
        $this->add = $add;
        $this->delete = $delete;
        $this->get = $get;
        $this->update = $update;
    }

    public function list(): View
    {
        $authors = $this->listAll->execute();

        return view('books-catalog.author.list', compact('authors'));
    }

    public function adding(): View
    {
        return view('books-catalog.author.add');
    }

    /**
     * @throws \Throwable
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:books_authors,name',
        ]);

        /** @noinspection PhpUndefinedFieldInspection */
        $this->add->execute($request->name);

        $request->session()->push(
            'flash_massages',
            [
                'level' => 'success',
                'content' => __('books_authors.successfully_added'),
            ],
        );

        return redirect()->route('books-authors.list');
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
                'content' => __('books_authors.successfully_deleted'),
            ],
        );

        return redirect()->route('books-authors.list');
    }

    /** @noinspection PhpUndefinedFieldInspection */
    public function editing(Request $request): View
    {
        $author = $this->get->execute($request->id);

        return view('books-catalog.author.editing', compact('author'));
    }

    /**
     * @throws \Throwable
     * @noinspection PhpUndefinedFieldInspection
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|string|exists:books_authors,id',
            'name' => 'required|string|max:255|unique:books_authors,name',
        ]);

        $this->update->execute($request->id, $request->name);

        $request->session()->push(
            'flash_massages',
            [
                'level' => 'success',
                'content' => __('books_authors.successfully_updated'),
            ],
        );

        return redirect()->route('books-authors.list');
    }
}
