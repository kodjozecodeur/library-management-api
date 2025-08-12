<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retrieve all books
        return Books::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required|unique:books',
            'copies_available' => 'integer|min:1'
        ]);

        return Books::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Books $book)
    {
        //
        return $book;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Books $book)
    {
        //
        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Books $book)
    {
        //
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully - No content'], 200);
    }
}
