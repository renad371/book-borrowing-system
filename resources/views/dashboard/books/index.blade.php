@extends('layouts.main')

@section('content')
<div class="container" style="margin-top: 100px;">
    <!-- زر إنشاء كتاب جديد -->
    <div class="mb-3 text-end">
        <button class="btn btn-primary" onclick="openBookModal()">Create New Book</button>
    </div>

    <!-- جدول الكتب -->
    <table class="table table-bordered" id="books-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Country</th>
                <th>Status</th>
                <th>Cover Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book['id'] }}</td>
                <td>{{ $book['title'] }}</td>
                <td>{{ $book['author_name'] }}</td>
                <td>{{ $book['category'] }}</td>
                <td>{{ $book['status'] }}</td>
                <td><img src="{{ $book['cover_image'] }}" alt="Cover Image" width="50"></td>
                <td>
                    <!-- زر تعديل -->
                    <button class="btn btn-warning btn-sm" onclick="openBookModal({{ $book['id'] }}, '{{ $book['title'] }}', '{{ $book['author_name'] }}', '{{ $book['category'] }}')">Edit</button>
                    <!-- زر حذف -->
                    <form method="POST" action="{{ route('delete_book', $book['id']) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form id="bookForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="methodField"></div>

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="bookModalLabel">Add Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="book_id" id="book_id">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <select class="form-control" id="author" name="author_id" required>
                    @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" required value="{{ old('category') }}">
            </div>
            <div class="mb-3">
                <label for="published_at" class="form-label">Published Date</label>
                <input type="date" class="form-control" id="published_at" name="published_at" required value="{{ old('published_at') }}">
            </div>
            <div class="mb-3">
                <label for="language" class="form-label">Language</label>
                <input type="text" class="form-control" id="language" name="language" required value="{{ old('language') }}">
            </div>
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>

    </div>
</div>

@endsection

@section('scripts')
<script>
   function openBookModal(id = null, title = '', author_name = '', category = '', published_at = '', language = '') {
    const modal = new bootstrap.Modal(document.getElementById('bookModal'));
    const modalTitle = document.getElementById('bookModalLabel');
    const form = document.getElementById('bookForm');
    const methodField = document.getElementById('methodField');

    if (id) {
        modalTitle.innerText = 'Edit Book';
        form.action = `/edit_book/${id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    } else {
        modalTitle.innerText = 'Add Book';
        form.action = `{{ route('add_book') }}`;
        methodField.innerHTML = '';
    }

    document.getElementById('book_id').value = id || '';
    document.getElementById('title').value = title || '';
    document.getElementById('author').value = author_name || '';
    document.getElementById('category').value = category || '';
    document.getElementById('published_at').value = published_at || '';
    document.getElementById('language').value = language || '';

    modal.show();
}

    // Initialize DataTables
    $(document).ready(function() {
        $('#books-table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": false,
        });
    });
</script>
@endsection
