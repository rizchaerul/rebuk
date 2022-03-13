<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $books  = Book::where('user_id', '!=', auth()->user()->id)->paginate(12);
        }
        else $books = Book::paginate(12);

        return view('books', [
            'books' => $books,
            'title' => 'All Category'
        ]);
    }

    public function uploadPage() {
        return view('upload');
    }

    public function user() {
        return view('books', [
            'books' => Book::where('user_id', auth()->user()->id)->paginate(12),
            'title' => 'My Books'
        ]);
    }

    public function book($bookId) {
        $book = Book::where('id', $bookId)->first();
        // $reviews = Review::where('assistant_id', $assistant->id)->paginate(5);
        $transactions = Transaction::where('book_id', $book->id)->get();

        $dates = array();

        for($i = 1; $i <= 14; $i++) {
            $isAvailable = true;

            foreach($transactions as $transaction) {
                // echo  $transaction->date.'<br>';
                // echo Carbon::now()->addDay($i)->toDateString().'<br>';

                if(Carbon::today()->addDay($i)->toDateString() == $transaction->date) {
                    $isAvailable = false;
                    break;
                }
            }

            if($isAvailable == true) array_push($dates, Carbon::today()->addDay($i));
        }

        return view('book', [
            'book' => $book,
            // 'reviews' => $reviews,
            'dates' => $dates
        ]);

        // return view('book', [
        //     'book' => Book::where('id', $bookId)->first()
        // ]);
    }

    public function category($categoryId) {
        if (Auth::check()) {
            $books  = Book::where('user_id', '!=', auth()->user()->id)->where('category_id', $categoryId)->paginate(12);
        }
        else $books = Book::where('category_id', $categoryId)->paginate(12);

        return view('books', [
            'books' => $books,
            'title' => Category::where('id', $categoryId)->first()->name.' Category'
        ]);
    }

    public function search(Request $request) {
        if (Auth::check()) {
            $books  = Book::where('user_id', '!=', auth()->user()->id)->where('title', 'like', "%$request->search%")->paginate(12);
        }
        else $books = Book::where('title', 'like', "%$request->search%")->paginate(12);

        return view('books', [
            'books' => Book::where('title', 'like', "%$request->search%")->paginate(12),
            'title' => 'Search results for '.'"'.$request->search.'"'
        ]);
    }

    public function delete($id) {
        $book = Book::where('id', $id)->first();
        // Storage::delete($book->image);
        File::delete("storage/$book->image");
        $book->delete();

        $userId = auth()->user()->id;
        return redirect("/books/user/$userId");
    }
}
