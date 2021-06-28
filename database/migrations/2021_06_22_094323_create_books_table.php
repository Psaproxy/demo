<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up(): void
    {
        if (false === Schema::hasTable('books')) {
            Schema::create('books', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('author_id', 36);
                $table->string('title');
                $table->timestamps();

                $table->foreign('author_id')->references('id')->on('books_authors')->cascadeOnDelete();
                $table->unique(['author_id', 'title']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
}
