<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author_name' => $book->author->name ?? 'Unknown',
                'status' => $book->status,
                'cover_image' => $book->cover_image ? Storage::url($book->cover_image) : null,
            ];
        });

        return view('book.index', compact('books'));
    }

    public function adminIndex()
    {
        $books = Book::with('author')->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author_name' => $book->author->name ?? 'Unknown',
                'status' => $book->status,
                'category' => $book->category,
                'cover_image' => $book->cover_image ? Storage::url($book->cover_image) : null,
            ];
        });
        $authors = Author::all();

        return view('dashboard.books.index', compact('books', 'authors'));
    }




    public function showBooks()
    {
        $books = Book::all()->map(function ($book) {
            return [
                'title' => $book->title,
                'author_id' => $book->author,
                'status' => $book->status,
                'cover_image' => Storage::url($book->cover_image) 
            ];
        });

        return response()->json($books);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'published_at' => 'required|date',
            'category' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'language' => 'required|string',
        ]);


        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('books', 'public');
            $validatedData['cover_image'] = $imagePath;
        }

        Book::create($validatedData);

        return redirect()->back()->with('success', 'Book added successfully');
    }

    
    public function borrow(Request $request)
    {

        $book = Book::find($request->input('book_id'));
        if ($book->status === 'borrowed') {
            return response()->json(['message' => 'Already borrowed'], 400);
        }

        $book->borrows()->create(['borrowable' => Auth::id(), 'borrowed_at' => now()]);
        $book->update(['status' => 'borrowed']);


        return response()->json([
            'status' => 'success',
            'message' => 'Book borrowed successfully'
        ]);
    }



    public function return(Borrow $borrow)
    {
        $book = Book::find($borrow->book_id);


        if ($book->status === 'available') {
            return response()->json(['message' => 'Already returned'], 400);
        } {
            $borrow = $book->borrows()
                ->where('borrowable', Auth::id())
                ->whereNull('returned_at')
                ->latest()
                ->first();

            if (!$borrow) {
                return response()->json(['message' => 'Invalid operation'], 400);
            }

            $borrow->update(['returned_at' => now()]);
            $book->update(['status' => 'available']);

            return response()->json(['message' => 'Book returned successfully']);
        }
    }
    public function show(Book $book)
    {

        $book->load('author', 'ratings.user');

        $book->is_available = $book->status === 'available';
        $book->average_rating = $book->ratings()->avg('rating') ?? 0;
        $book->ratings_count = $book->ratings()->count();
        $book->rating_counts = $book->ratings()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();
        $book->borrows_count = $book->borrows()->count();
        $book->reviews_count = $book->ratings()->count();


        $userReview = null;
        if (auth()->check()) {
            $userReview = $book->ratings()
                ->where('user_id', auth()->id())
                ->first();
        }

        $hasBorrowedBefore = Borrow::where('borrowable', auth()->id())
            ->where('book_id', $book->id)
            ->whereNotNull('returned_at') // يعني أنه استعار ورجع الكتاب
            ->exists();


        $reviews = $book->ratings()
            ->with('user')
            ->latest()
            ->paginate(5);



        return view('book.show', compact('book', 'userReview', 'reviews', 'hasBorrowedBefore'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }
    public function update(Request $request, Book $book)
    {

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'author_id' => 'sometimes|exists:authors,id',
            'published_at' => 'sometimes|date',
            'category' => 'sometimes|string',
            'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'language' => 'sometimes|string',
            'copies_available' => 'sometimes|integer|min:0',
        ]);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }


        if ($request->hasFile('cover_image')) {

            if ($book->cover_image) {
                Storage::delete($book->cover_image);
            }


            $validatedData['cover_image'] = $request->file('cover_image')->store('books');
        }


        $book->update($validatedData);

        return redirect()->back()->with('success', 'Book updated successfully');
    }
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }
}
