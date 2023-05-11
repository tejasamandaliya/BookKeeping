<?php

namespace App\Http\Controllers\API\Book;

use App\Models\Book;
use App\Models\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BookController extends Controller
{

    public function destroy($id)
    {
        $book = Book::where('id', $id)->delete();
        if ($book)
            return sendSuccess('Book successfully deleted');
        else
            return sendError('Book not exists');
    }

    public function store(Request $request)
    {
        $book = new Book;
        $book->name = $request->name;
        $book->author_id = $request->author_id;
        $book->save();
        return sendResponse($book);
    }
}
