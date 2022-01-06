<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use http\Env\Response;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $authors = Author::get();
        $books = Book::with('Category','Author')->get();
        return view('index',compact('authors','categories','books'));
    }

    public function store(Request $request){
        try {
            $book = new Book();
            $book->name = $request->input('name');
            $book->author_id = $request->author_id;
            $book->category_id = $request->category_id;
            $book->save();
            return response()->json([
                'id' => $book->id,
                'name' => $book->name,
                'category_name' =>  $book->Category->category_name,
                'author_name' =>     $book->Author->name]
            );

        }
        catch (\Throwable $th){
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $book = Book::find($id);
            $book->delete();
            return response()->json(['success'=>'Kitap Silme işlemi Başarılı']);
        }
        catch (\Throwable $th){
            return response()->json([''=>'İşlem ']);
        }

    }

}
