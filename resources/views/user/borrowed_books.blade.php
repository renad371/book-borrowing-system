@extends('layouts.main')

@section('title', 'Borrowed Books')

@section('css')
<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<style>
    .borrowed-books-container {
        padding-top: 100px;
    }

    h2.title {
        font-weight: bold;
        font-size: 28px;
        margin-bottom: 30px;
        text-align: center;
        color: rgba(7, 31, 59, 0.95);
    }

    #borrowedBooksTable {
        background-color: #f4f7fc;
        border-radius: 8px;
        overflow: hidden;
    }

    #borrowedBooksTable thead {
        background-color: rgb(78, 160, 243);
        color: white;
    }

    #borrowedBooksTable th,
    #borrowedBooksTable td {
        vertical-align: middle;
        text-align: center;
        padding: 10px;
        font-size: 16px;
    }

    #borrowedBooksTable tbody tr:nth-child(even) {
        background-color: rgba(78, 160, 243, 0.1);
    }

    #borrowedBooksTable tbody tr:nth-child(odd) {
        background-color: rgba(7, 31, 59, 0.05);
    }

    #borrowedBooksTable tbody tr:hover {
        background-color: rgba(78, 160, 243, 0.3);
        cursor: pointer;
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px;
        text-align: left;
    }

    .btn-danger {
        border-radius: 8px;
    }

    .alert {
        text-align: center;
        font-size: 16px;
        padding: 10px;
        background-color: #ffcc00;
        color: #333;
    }

    .dt-button {
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
<div class="container borrowed-books-container">
    <h2 class="title">Borrowed Books</h2>

    @if(session('message'))
    <div class="alert alert-warning">{{ session('message') }}</div>
    @else
    <table id="borrowedBooksTable" class="table table-bordered table-striped shadow-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Book Title</th>
                <th>Language</th>
                <th>Category</th>
                <th>Borrowed Date</th>
                <th>Return Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrows as $index => $borrow)
            <tr data-borrow-id="{{ $borrow->id }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $borrow->book->title }}</td>
                <td>{{ $borrow->book->language }}</td>
                <td>{{ $borrow->book->category }}</td>
                <td>{{ $borrow->borrowed_at }}</td>
                <td>{{ $borrow->returned_at ?? 'Not Returned' }}</td>
                <td>

                    @if(is_null($borrow->returned_at))
                    <form id="ReturnForm" action="{{ route('return', $borrow->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST')
                        <button type="submit" id="ReturnButton" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-arrow-left me-2"></i> Return Book
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection

@section('scripts')
<!-- Load jQuery library first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load DataTables and Buttons libraries -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- Load PDFMake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize DataTables with export buttons
        let table = $('#borrowedBooksTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/en.json'
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                text: 'Export as PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function(doc) {
                    doc.defaultStyle.alignment = 'center';
                    doc.styles.tableHeader.alignment = 'center';
                    doc.styles.tableBodyEven.alignment = 'center';
                    doc.styles.tableBodyOdd.alignment = 'center';
                }
            }],
        });

        // Handle book return

        $(document).ready(function() {
            $('#ReturnForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                var form = $(this); // Get the form
                var formData = form.serialize(); // Serialize form data
                var ReturnButton = $('#ReturnButton'); // Borrow button

                $.ajax({
                    url: form.attr('action'), // The URL to send the request to
                    type: 'POST',
                    data: formData, // The data to send
                    success: function(response) {
                        // On success
                        alert(response.message); // Display success message
                        ReturnButton.prop('disabled', true); // Disable the borrow button
                        ReturnButton.text('Book Returned'); // Change button text
                        // Update table or remove the relevant row
                        form.closest('tr').find('td').eq(5).text('Returned'); // Update the return status in the table
                    },
                    error: function(xhr) {
                        // On error
                        alert(xhr.responseJSON.message); // Display error message
                    }
                });
            });
        });
    });
</script>

@endsection
