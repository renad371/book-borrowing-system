@extends('layouts.main')

@push('styles')
<style>
    /* ... (keep existing styles) ... */
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 100px;">
    <div class="container">
        <!-- Author Information -->
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="author-details">
                    <h1 class="author-name">{{ $author->name }}</h1>

                    <div class="author-bio mb-4">
                        <h3 class="section-title">Biography</h3>
                        <p class="bio-text">{{ $author->bio ?? 'No biography available for this author.' }}</p>
                    </div>

                    <div class="author-rating mt-3">
                        <div class="rating-stars d-inline-block">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=$author->average_rating)
                                <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $author->average_rating)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                    <i class="far fa-star text-warning"></i>
                                    @endif
                                    @endfor
                        </div>
                        <span class="rating-value ms-2">{{ number_format($author->average_rating, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Author's Books -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="books-section">
                    <h2 class="section-title mb-4">Author's Books</h2>

                    @if($books->isEmpty())
                    <div class="alert alert-info text-center py-4">
                        <i class="fas fa-book-open fa-3x mb-3"></i>
                        <h4>No books registered for this author</h4>
                    </div>
                    @else
                    <div class="row g-4">
                        @foreach($books as $book)
                        <x-book-card :book="$book" :show-actions="true" />
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Author's Reviews -->
        <div class="row">
            <div class="col-12">
                <div class="reviews-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="section-title">Ratings and Reviews</h2>

                        @auth
                        @if($hasReadBook)
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="fas fa-plus me-2"></i> Add Review
                        </button>
                        @else
                        <span class="text-muted small">You can add a review after reading a book by this author.</span>
                        @endif
                        @endauth
                    </div>
                    <!-- Review Modal -->
                    @auth
                    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="reviewForm" action="{{ route('rating', $author->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rateable_id" value="{{ $author->id }}">
                                    <input type="hidden" name="rateable_type" value="author">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Rate this author</h5>
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

                    @if($author->ratings->isEmpty())
                    <div class="alert alert-info text-center py-4">
                        <i class="fas fa-comments fa-3x mb-3"></i>
                        <h4>No reviews for this author</h4>
                        <p>Be the first to review this author</p>
                    </div>
                    @else
                    <div class="reviews-list" id="reviewsList">
                        @foreach($author->ratings as $review)
                        <div class="review-item mb-4 p-4 border rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="user-info d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold">{{ $review->user->name }}</div>
                                        <small class="text-muted"> {{ $review->review_text }}</small>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=$review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                        @else
                                        <i class="far fa-star text-warning"></i>
                                        @endif
                                        @endfor
                                </div>
                            </div>
                            <div class="review-content">
                                <p class="mb-2">{{ $review->comment }}</p>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
   
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
                    if (response.success) {
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
@endpush