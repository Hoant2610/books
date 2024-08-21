<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\ImageService;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    private BookService $bookService;
    private ImageService $imageService;

    public function __construct(BookService $bookService,ImageService $imageService)
    {
        $this->bookService = $bookService;
        $this->imageService = $imageService;
    }

    public function viewBooks(Request $request)
    {

        $books = $this->bookService->getPaginateBookDTO(Book::All(),10);
        return view('admin.book')->with("books", $books);
    }
    public function findBook(Request $request)
    {
        $books = $this->bookService->findBookByKey($request->key,10);
        return view('admin.book')->with("books", $books);
    }
    public function viewDetailBook($slug)
    {
        $book = $this->bookService->findBookBySlug($slug);
        $categories = Category::all();
        return view('admin.book-detail')->with("book", $book)->with("categories",$categories);
    }
    public function getImgs(){
        return response()->json(['imgs'=>$this->imageService->getImgs()]);
    }
    public function uploadImage(Request $request){
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            return $this->imageService->uploadImage($files);
        }
    }
    public function changeThumbnail(Request $request){
        $slug = $request->slug;
        $selectedImgPath = $request->selectedImgPath;
        $newThumbnail = $this->bookService->changeThumbnailBySlug($slug,$selectedImgPath);
        return response()->json(['newThumbnail'=>$newThumbnail]);
    }
    public function updateDetailBook($slug,Request $request){
        $name = $request->name;
        $category = $request->category;
        $quantity = $request->quantity;
        $sale_price = $request->sale_price;
        $original_price = $request->original_price;
        $status = $request->status;
        $description = $request->description;
        return response()->json(['newSlug'=>$this->bookService->updateBookBySlug($slug,$name,$category,$quantity,$sale_price,$original_price,$status,$description)]);
    }
    public function viewCreateBook(){
        $categories = Category::all();
        return view('admin.book-create')->with("categories",$categories);
    }
    public function createBook(Request $request){
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'imgs/' . $filename;
            // Lưu file vào thư mục public/imgs
            $file->move(public_path('imgs'), $filename);
        }
        $category_id = $request->category_id;
        $name = $request->name;
        $quantity = $request->quantity;
        $sale_price = $request->salePrice;
        $original_price = $request->originalPrice;
        $status = $request->status;
        $description = $request->description;
        $author = $request->author;
        if(!$author){
            $author = "unknown";
        }
        $book = $this->bookService->createBook($category_id,$name,$original_price,$sale_price,$description,$quantity,$status,$author,$filePath);
        return response()->json(['message'=>"Create successfully!","slug"=>$book->slug]);
    }
}


