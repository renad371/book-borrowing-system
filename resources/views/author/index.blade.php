@extends('layouts.main')

@section('content')
<div class="container" style="padding-top: 100px;">
    <h1 class="mb-4">Authors</h1>
    <div class="row">
        @foreach($authors as $author)
        <div class="col-md-4 mb-4">
            <x-author-card :author="$author" />
        </div>
        @endforeach

    </div>
</div>
@endsection