<div class="col-md-4 mb-4">
    <a href="/books/{{ $book['id'] ?? '' }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-img-top position-relative overflow-hidden" style="height: 250px; background-color: #f5f5f5;">
                @if(!empty($book['cover_image']))
                    <img src="{{ $book['cover_image'] }}" 
                         alt="{{ $book['title'] }}" 
                         class="img-fluid h-100 w-100 object-fit-cover">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <i class="fas fa-book-open fa-4x text-muted"></i>
                    </div>
                @endif
                
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge rounded-pill {{ $book['status'] === 'available' ? 'bg-success' : 'bg-danger' }}">
                        {{ $book['status'] ?? 'Unknown' }}
                    </span>
                </div>
            </div>
            
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-2">{{ $book['title'] ?? 'No Title' }}</h5>
                <p class="card-text text-muted mb-3">By {{ $book['author_name'] ?? 'Unknown Author' }}</p>
            </div>
        </div>
    </a>
</div>
