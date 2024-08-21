<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function getAll()
    {
        return Book::all();
    }
    public function getPaginateBook($perPage)
    {
        return Book::paginate($perPage);
    }

    public function findById($id)
    {
        $book = Book::find($id);
        return $book;
    }

    public function findBySlug($slug)
    {
        $book = Book::whereSlug($slug)->firstOrFail();
        return $book;
    }

    public function findByKey($key)
    {
        $key = trim($key);
        $books = Book::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($key) . '%'])
             ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($key) . '%'])->get();
        return $books;
    }
}
