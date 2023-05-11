<?php

namespace App\Http\Controllers\API\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::paginate();
        return sendResponse($authors);
    }

    public function destroy($id)
    {
        $author = Author::where('id', $id)->whereDoesntHave('book')->delete();

        if ($author)
            return sendSuccess('Author successfully deleted');
        else
            return sendError('Record not found');
    }

    public function getAuthorBooks($id)
    {
        $author = Author::with('books')->where('id', $id)->first();
        return sendResponse($author);
    }
}
