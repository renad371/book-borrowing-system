@extends('layouts.main')

@section('content')
<div class="container" style="padding-top: 100px;">

    <div class="row">
        @if($books->count() > 0)
        @foreach($books as $book)
        <x-book-card :book="$book" :show-actions="true" />
        @endforeach

        @else
        <div class="col-12 text-center py-5">
            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">No books available</h3>
            <p class="text-muted">Please check back later</p>
        </div>
        @endif
    </div>
</div>
@endsection