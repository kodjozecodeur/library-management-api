<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Rentals;
use Illuminate\Http\Request;

class RentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Rentals::with(['book', 'member'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'due_at' => 'required|date'
        ]);

        $book = Books::find($request->book_id);

        if ($book->copies_available < 1) {
            return response()->json(['error' => 'No copies available'], 400);
        }

        $book->decrement('copies_available');

        return Rentals::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'rented_at' => now(),
            'due_at' => $request->due_at
        ]);
    }
    public function returnBook(Rentals $rental)
    {
        if ($rental->returned_at) {
            return response()->json(['error' => 'Book already returned'], 400);
        }

        $rental->update(['returned_at' => now()]);
        $rental->book->increment('copies_available');

        return $rental;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

