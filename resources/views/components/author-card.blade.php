
<div class="card author-card">
    <div class="card-body">
        <h5 class="card-title">{{ $author->name }}</h5>
        <p class="card-text">
            {{ $author->bio ?? 'No bio available.' }}
        </p>
        <a href="{{ route('author', $author->id) }}" class="btn btn-primary">View Profile</a>
    </div>
</div>
