@extends('layouts.main')

@section('content')
<div class="book-detail-page py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Books</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Book Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Book Info -->
        <div class="row mb-5">
            <!-- Cover -->
            <div class="col-md-4 mb-4">
                <div class="book-cover-container shadow-lg">
                    <img src="{{ $book->cover_image ? Storage::url($book->cover_image) : asset('images/default-cover.png') }}"
                        alt="{{ $book->title }}" class="img-fluid rounded">
                    @auth
                    <div class="book-actions mt-3">
                        @if($book->is_available)
                        <form id="borrowForm" action="{{ route('borrow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <!-- استخدم نوع button واستمع للنقر عليه -->
                            <button type="button" class="btn btn-primary btn-lg w-100" id="borrowButton">
                                <i class="fas fa-bookmark me-2"></i> Borrow Book
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="fas fa-ban me-2"></i> Currently Unavailable
                        </button>
                        @endif
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Details -->
            <div class="col-md-8">
                <div class="book-details">
                    <h1 class="book-title">{{ $book->title }}</h1>
                    <p class="book-author">Author:
                        <a href="{{ route('author', $book->author->id) }}">{{ $book->author->name }}</a>
                    </p>

                    <!-- Rating -->
                    <div class="book-rating mb-4">
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $book->average_rating)
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $book->average_rating)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="ms-2">{{ number_format($book->average_rating, 1) }}</span>
                            <span class="rating-count">({{ $book->ratings_count }} ratings)</span>
                        </div>

                        <div class="rating-distribution mt-2">
                            @for($r = 5; $r >= 1; $r--)
                            @php
                                $percentage = $book->ratings_count > 0
                                    ? ($book->rating_counts[$r] ?? 0) / $book->ratings_count * 100
                                    : 0;
                            @endphp
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">{{ $r }} <i class="fas fa-star text-warning"></i></span>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $percentage }}%;"></div>
                                </div>
                                <span class="ms-2 text-muted small">{{ $book->rating_counts[$r] ?? 0 }}</span>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="book-meta mb-4">
                        <div><i class="fas fa-calendar-alt me-2"></i> Published: {{ $book->published_at ?? 'Unknown' }}</div>
                        <div><i class="fas fa-layer-group me-2"></i> Category: {{ $book->category ?? 'Uncategorized' }}</div>
                        <div><i class="fas fa-file-alt me-2"></i> Pages: {{ $book->pages ?? 'Unknown' }}</div>
                        <div><i class="fas fa-language me-2"></i> Language: {{ $book->language ?? 'Unknown' }}</div>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                    <div class="book-description mb-4">
                        <h5>Description</h5>
                        <p>{{ $book->description }}</p>
                    </div>
                    @endif

                    <!-- Stats -->
                    <div class="book-stats d-flex gap-4">
                        <div><strong>{{ $book->borrows_count }}</strong><br><small>Borrowed</small></div>
                        <div><strong>{{ $book->reviews_count }}</strong><br><small>Reviews</small></div>
                        <div><strong>{{ $book->available_copies }}</strong><br><small>Available Copies</small></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row">
            <div class="col-12">
                <div class="reviews-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Ratings and Reviews</h2>
                        @auth
                        @if($hasBorrowedBefore)
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="fas fa-plus me-2"></i> Add Review
                        </button>
                        @else
                        <span class="text-muted small">You can add a review after borrowing the book.</span>
                        @endif
                        @endauth
                    </div>

                    <!-- Review Modal -->
                    @auth
                    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="reviewForm" action="{{ route('rating', $book->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rateable_id" value="{{ $book->id }}">
                                    <input type="hidden" name="rateable_type" value="book">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Rate this Book</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Your Rating</label>
                                            <div class="rating-input">
                                                @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                                    {{ old('rating', $userReview->rating ?? 0) == $i ? 'checked' : '' }}>
                                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                                @endfor
                                            </div>
                                            @error('rating') <div class="text-danger small">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Your Review</label>
                                            <textarea name="review_text" class="form-control" rows="3">{{ old('review_text', $userReview->comment ?? '') }}</textarea>
                                            @error('review_text') <div class="text-danger small">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="submitReviewBtn">Submit Review</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth

                    <!-- User Review -->
                    @auth
                    @if($userReview)
                    <div class="user-review bg-light p-4 rounded mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ Auth::user()->avatar_url }}" class="rounded-circle me-2" width="40">
                                <strong>{{ Auth::user()->name }}</strong>
                            </div>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $userReview->rating)
                                    <i class="fas fa-star text-warning"></i>
                                    @else
                                    <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <button class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </div>
                        <p>{{ $userReview->comment }}</p>
                        <small class="text-muted">{{ $userReview->created_at->diffForHumans() }}</small>
                    </div>
                    @endif
                    @endauth

                    <!-- All Reviews -->
                    <div id="reviewsList">
                        @foreach($reviews as $review)
                        <div class="user-review bg-light p-4 rounded mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $review->user->avatar_url }}" class="rounded-circle me-2" width="40">
                                    <strong>{{ $review->user->name }}</strong>
                                </div>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                        @else
                                        <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p>{{ $review->comment }}</p>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Ajax for Borrow Book
        $('#borrowButton').click(function(e) {
            e.preventDefault();
            var $form = $('#borrowForm');
            var $borrowButton = $(this);
            var url = $form.attr('action');
            var data = $form.serialize();

            $borrowButton.prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json', 
                success: function(response) {
                    console.log(response); 
                    if(response.success){
                        alert(response.message); 
                        
                        $borrowButton.text('Book Borrowed')
                                     .removeClass('btn-primary')
                                     .addClass('btn-secondary');
                    } else {
                        alert(response.message || 'Something went wrong. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred: ' + error);
                }
                // يمكن عدم إعادة تمكين الزر إذا كانت العملية نهائية
            });

        });

        // Ajax for Review Submission
        $('#reviewForm').submit(function(e) {
            e.preventDefault();
            var $form = $(this);
            var $submitButton = $form.find('#submitReviewBtn');
            var url = $form.attr('action');
            var data = $form.serialize();

            $submitButton.prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json', // نتوقع استجابة بصيغة JSON
                success: function(response) {
                    console.log(response); // التحقق من الاستجابة عبر وحدة التحكم
                    if(response.success) {
                        // إضافة التقييم الجديد لقسم المراجعات دون إعادة تحميل الصفحة
                        $('#reviewsList').prepend(response.reviewHtml);
                        $('#reviewModal').modal('hide');
                        alert(response.message || 'Review submitted successfully!');
                    } else {
                        alert(response.message || 'Something went wrong. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred: ' + error);
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
