<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function __construct(Book $book,)
    {
        $this->middleware('permission:book-list|book-create|book-edit|book-delete', ['only' => ['index','show']]);
        $this->middleware('permission:book-create', ['only' => ['create','store']]);
        $this->middleware('permission:book-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:book-delete', ['only' => ['destroy']]);
        $this->book = $book;
    }

    public function index()
    {
        $book = $this->book->getFillable();
        return view('book.index',compact('book'));
    }


    public function create()
    {
        return view('book.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name'         => 'required',
            'author'       => 'required',
            'publish_date' => 'required',
            'import_price' => 'required',
            'sale_price'   => 'required',
            'status'       => 'required',
        ]);
        Book::create($request->all());

        return redirect()->route('book.index')
                         ->with('success','Entry created successfully.');
    }

    public function show(Book $book)
    {
        return view('book.show',compact('book'));
    }

    public function edit(Book $book)
    {
        return view('book.edit',compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        request()->validate([
            'name'         => 'required',
            'author'       => 'required',
            'publish_date' => 'required',
            'import_price' => 'required',
            'sale_price'   => 'required',
            'status'       => 'required',
        ]);

        $book->update($request->all());

        return redirect()->route('book.index')
                         ->with('success','Entry updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')
                         ->with('success','Entry deleted successfully');
    }
}
