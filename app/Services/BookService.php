<?php

namespace App\Services;

use App\Models\Book;
use App\DTOs\customer\BookDTO;
use App\Repositories\BookRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    private BookRepository $bookRepository;
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    public function getBookById($id){
        return $this->bookRepository->findById($id);
    }
    public function getPaginateBook($perPage)
    {
        return $this->bookRepository->getPaginateBook($perPage);
    }

    public function getPaginateBookDTO($books,$perPage)
    {
        $bookDTOs = $books->map(function ($book) {
            return new BookDTO($book);
        });
        // Tạo một collection từ danh sách các DTOs
        $bookCollection = collect($bookDTOs);
        // Xác định trang hiện tại
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Lấy các mục cho trang hiện tại
        $currentPageItems = $bookCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Tạo paginator mới với các DTOs
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $bookCollection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return $paginatedItems;
        // return $booksDTO->pagiante(10);
    }

    public function findBookByKey($key,$perPage)
    {
        // trả về kiểu BookDTO
        $book = $this->bookRepository->findByKey($key);
        $bookDTOs = $book->map(function ($book) {
            return new BookDTO($book);
        });
        // Tạo một collection từ danh sách các DTOs
        $bookCollection = collect($bookDTOs);
        // Xác định trang hiện tại
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Lấy các mục cho trang hiện tại
        $currentPageItems = $bookCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Tạo paginator mới với các DTOs
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $bookCollection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return $paginatedItems;
    }

    public function findBookBySlug($slug)
    {
        return new BookDTO($this->bookRepository->findBySlug($slug));
    }
    public function changeThumbnailBySlug($slug,$path){
        $book = $this->bookRepository->findBySlug($slug);
        $book->thumbnail = $path;
        $book->save();
        return '/'.$book->thumbnail;
    }
    public function updateBookBySlug($slug,$name,$category,$quantity,$sale_price,$original_price,$status,$description){
        $book = $this->bookRepository->findBySlug($slug);
        $book->name = $name;
        $book->category_id = $category;
        $book->quantity = $quantity;
        $book->sale_price = $sale_price;
        $book->original_price = $original_price;
        $book->status = $status;
        $book->description = $description;
        $book->save();
        return $book->slug;
    }
    public function createBook($category_id,$name,$original_price,$sale_price,$description,$quantity,$status,$author,$thumbnail){
        
        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'original_price' => $original_price,
            'sale_price' => $sale_price,
            'description' => $description,
            'quantity' => $quantity,
            'status' => $status,
            'author' => $author,
            'publish' => "unknown",
            'thumbnail' => $thumbnail,
        ];
        $book = Book::create($data);
        return $book;
    }
}