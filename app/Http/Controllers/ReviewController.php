<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use App\Models\Author;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'review_text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'rateable_id' => 'required|integer',
            'rateable_type' => 'required|string|in:book,author',
        ]);
    
        $userId = Auth::id();
    
        // Check if the user has already reviewed the book or author
        $existingReview = Review::where('user_id', $userId)
                                ->where('rateable_id', $validatedData['rateable_id'])
                                ->where('rateable_type', $validatedData['rateable_type'])
                                ->first();
    
        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'review_text' => $validatedData['review_text'],
                'rating' => $validatedData['rating'],
            ]);
    
            return response()->json([
                'success' => true,
                'review' => [
                    'review_text' => $existingReview->review_text,
                    'rating' => $existingReview->rating,
                    'user_name' => $existingReview->user->name,
                    'created_at' => $existingReview->created_at->diffForHumans(),
                ]
            ]);
        }
    
        // Validation for borrowing the book or author
        // Assuming the borrowed validation for "book" is sufficient
    
        // Create new review if it doesn't exist
        $review = Review::create([
            'review_text' => $validatedData['review_text'],
            'rating' => $validatedData['rating'],
            'user_id' => $userId,
            'rateable_id' => $validatedData['rateable_id'],
            'rateable_type' => $validatedData['rateable_type'] === 'book' ? 'App\Models\Book' : 'App\Models\Author',
        ]);
    
        return response()->json([
            'success' => true,
            'review' => [
                'review_text' => $review->review_text,
                'rating' => $review->rating,
                'user_name' => $review->user->name,
                'created_at' => $review->created_at->diffForHumans(),
            ]
        ]);
    }
    
}
 

