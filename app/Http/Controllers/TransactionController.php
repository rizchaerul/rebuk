<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Report;
use App\Review;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    function review(Request $request, $transactionId) {
        $this->validate($request, [
            'title' => 'required',
            'rating' => 'required|numeric',
            'description' => 'required'
        ]);

        Review::create([
            'title' => $request->title,
            'description' => $request->description,
            'rating' => $request->rating,
            'transaction_id' => $transactionId
        ]);

        $book = Transaction::where('id', $transactionId)->first()->book;

        $total = 0;

        foreach ($book->reviews as $review) {
            $total += $review->rating;
        }

        $book->rating = $total / count($book->reviews);
        $book->save();

        return back();
    }

    function report(Request $request, $transactionId) {
        $this->validate($request, [
            'description' => 'required'
        ]);

        Report::create([
            'description' => $request->description,
            'transaction_id' => $transactionId,
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiverId
        ]);

        return back();
    }

    function index() {
        $transactions = Transaction::where('date', '<' ,Carbon::today())->where('status', 'Pending')->get();

        foreach ($transactions as $transaction) {
            $user = $transaction->customer;
            $user->coin += 10;
            $user->save();

            $transaction->delete();
        }
        //

        $transactions = Transaction::where('customer_id', auth()->user()->id)->get();

        $dates = array();

        foreach($transactions as $tr) {
            $current = Carbon::parse($tr->date);

            if($current->addDay()->isFuture()) {
                array_push($dates, $tr);
            }
        }

        $requests = Transaction::where('owner_id', auth()->user()->id)->get();

        $arr = array();

        foreach($requests as $tr) {
            $current = Carbon::parse($tr->date);

            if($current->addDay()->isFuture()) {
                array_push($arr, $tr);
            }
        }
        
        return view('ongoing', [
            'transactions' => $dates,
            'requests' => $arr
        ]);
    }

    function history() {
        $transactions = Transaction::where('date', '<' ,Carbon::today())->where('status', 'Pending')->get();

        foreach ($transactions as $transaction) {
            $user = $transaction->customer;
            $user->coin += 10;
            $user->save();

            $transaction->delete();
        }
        //

        $transactions = Transaction::where('customer_id', auth()->user()->id)->get();

        $dates = array();

        foreach($transactions as $tr) {
            $current = Carbon::parse($tr->date);

            if($current->addDay()->isPast()) {
                array_push($dates, $tr);
            }
        }

        $requests = Transaction::where('owner_id', auth()->user()->id)->get();

        $arr = array();

        foreach($requests as $tr) {
            $current = Carbon::parse($tr->date);

            if($current->addDay()->isPast()) {
                array_push($arr, $tr);
            }
        }
        
        return view('history', [
            'transactions' => $dates,
            'requests' => $arr
        ]);
    }

    public function cancel(Request $request) {
        $tr = Transaction::where('id', $request->transaction_id)->first();

        if($tr->status == 'Pending') {
            // $user = User::where('id', auth()->user()->id)->first();
            $user = $tr->customer;

            $user->coin += 10;
            $user->save();
        }

        Transaction::where('id', $request->transaction_id)->delete();

        // return redirect('/ongoing')->with('status', 'Success Delete');
        return back();
    }

    public function deny(Request $request) {
        $tr = Transaction::where('id', $request->transaction_id)->first();

        if($tr->status == 'Pending') {
            // $user = User::where('id', $tr->customer_id)->first();
            $user = $tr->customer;

            $user->coin += 10;
            $user->save();
        }

        Transaction::where('id', $request->transaction_id)->delete();

        return back();
    }

    public function accept(Request $request) {
        $tr = Transaction::where('id', $request->transaction_id)->first();
        $tr->status = 'Accepted';
        $tr->save();

        // $user = User::where('id', auth()->user()->id)->first();
        $user = $tr->owner;
        $user->coin += 10;
        $user->save();

        return back();
    }

    function rent(Request $request, $bookId) {
        $this->validate($request, [
            'date' => 'required',
            'address' => 'required'
        ]);

        if(auth()->user()->coin < 60) {
            return back()->with('status', 'You must have at least 60 coins in your account');
        }

        Transaction::create([
            'date' => $request->date,
            'customer_id' => auth()->user()->id,
            'owner_id' => Book::where('id', $request->bookId)->first()->user->id,
            'book_id' => $request->bookId,
            'address' => $request->address
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->coin -= 10;
        $user->save();

        return back();
    }
}
