<?php


namespace Ampheris\ampController;

use App\Http\Controllers\Controller;
use App\Models\Book;

// Class for the book view. Could've been done without
// the controller and straight in web.php.
class Books extends Controller
{
    public function index()
    {
        $books = Book::all();

        return view('books', ['books' => $books]);
    }
}
