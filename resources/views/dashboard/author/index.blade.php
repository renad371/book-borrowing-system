@extends('layouts.main')

@section('content')
<div class="container" style="margin-top: 100px;">
    <!-- Button to open modal for creating a new author -->
    <div class="mb-3 text-end">
        <button class="btn btn-primary" onclick="openAuthorModal()">Add New Author</button>
    </div>

    <!-- Authors table -->
    <table class="table table-bordered" id="authors-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Bio</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($authors as $author)
            <tr>
                <td>{{ $author->id }}</td>
                <td>{{ $author->name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($author->bio, 50) }}</td>
                <td>
                    <!-- Edit button; changed color to blue info -->
                    <button class="btn btn-info btn-sm"
                        onclick="openAuthorModal({{ $author->id }}, '{{ addslashes($author->name) }}', `{{ addslashes($author->bio) }}`)">
                        Edit
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="authorModal" tabindex="-1" aria-labelledby="authorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="authorForm" method="POST">
            @csrf
            <div id="methodField"></div>

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authorModalLabel">Add Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="author_id" id="author_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Author Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4"></textarea>
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
<!-- DataTables -->
<script>
    $(document).ready(function() {
        $('#authors-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/en-GB.json"

            }
        });
    });

    function openAuthorModal(id = null, name = '', bio = '') {
        const modal = new bootstrap.Modal(document.getElementById('authorModal'));
        const modalTitle = document.getElementById('authorModalLabel');
        const form = document.getElementById('authorForm');
        const methodField = document.getElementById('methodField');

        if (id) {
            modalTitle.innerText = 'Edit Author';
            form.action = `/edit_author/${id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        } else {
            modalTitle.innerText = 'Add Author';
            form.action = `{{ route('add_author') }}`;
            methodField.innerHTML = '';
        }

        document.getElementById('author_id').value = id || '';
        document.getElementById('name').value = name || '';
        document.getElementById('bio').value = bio || '';

        modal.show();
    }
</script>
@endsection