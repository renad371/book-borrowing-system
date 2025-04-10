<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Author;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Display a list of authors.
     */
    public function index()
    {

        $authors = Author::with('books')->get();
        return view(
            'author.index',
            compact('authors')
        );
    }

    public function adminINdex()
    {
        $authors = Author::with('books')->get();
        return view(
            'dashboard.author.index',
            compact('authors')
        );
    }
    /**
     * Show the form for creating a new author.

     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created author in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        Author::create($request->all());

        return redirect()->back()->with('success', 'Author added successfully!');
    }

    /**
     * Display the specified author.
     */
    public function show(Author $author)
    {
        $author->load(['books' => function ($query) {
            $query->withCount('borrows');
        }]);

        $author->average_rating = $author->ratings()->avg('rating') ?? 0;
        $author->ratings_count = $author->ratings()->count();
        $author->books_count = $author->books()->count();
        $author->total_reads = $author->books->sum('borrows_count');
        $author->load(['ratings.user', 'ratings.rateable']);

        $books = $author->books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author_name' => $book->author->name ?? 'Unknown',
                'status' => $book->status,
                'cover_image' => $book->cover_image ? Storage::url($book->cover_image) : null,
            ];
        });


        $hasReadBook = false;
        $userReview = null;

        if (auth()->check()) {
            $userBookIds = auth()->user()->borrows()->pluck('book_id')->toArray();
            $authorBookIds = $author->books->pluck('id')->toArray();
            $hasReadBook = count(array_intersect($userBookIds, $authorBookIds)) > 0;


            $userReview = $author->ratings()
                ->where('user_id', auth()->id())
                ->first();
        }

      
        return view('author.show', [
            'books' => $books,
            'author' => $author,
            'hasReadBook' => $hasReadBook,
            'userReview' => $userReview,
        ]);
    }


    /**
     * Show the form for editing the specified author.
     */
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified author in the database.
     */
    public function update(Request $request, Author $author)
    {
        $validatedData =  $request->validate([
            'name' => 'sometimes|string|max:255',
            'bio' => 'sometimes|string|max:1000',
        ]);

        $author->update($validatedData);

        return redirect()->back()->with('success', 'Author updated successfully!');
    }

    /**
     * Remove the specified author from the database.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully!');
    }
}
