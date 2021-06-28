<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksAuthorsTable extends Migration
{
    public function up():void
    {
        if (false === Schema::hasTable('books_authors')) {
            Schema::create('books_authors', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }
    }

    public function down():void
    {
        Schema::dropIfExists('books_authors');
    }
}
