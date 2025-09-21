@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 fw-bold">👥 User Management</h4>
            <a href="#" class="btn btn-light btn-sm rounded-pill shadow-sm">
                ➕ Add User
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-borderless align-middle" id="users-table" style="width:100%">
                <thead class="bg-light">
                    <tr>
                        <th class="text-secondary">#</th>
                        <th class="text-secondary">Name</th>
                        <th class="text-secondary">Email</th>
                        <th class="text-secondary">Joined</th>
                        <th class="text-secondary text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables with Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('users.data') }}",
        language: {
            search: "_INPUT_",
            searchPlaceholder: "🔍 Search users...",
            lengthMenu: "_MENU_ per page",
            paginate: {
                previous: "⬅️ Prev",
                next: "Next ➡️"
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {
                data: 'created_at', 
                name: 'created_at',
                render: function(data) {
                    return `<span class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">${data}</span>`;
                }
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                className: "text-center"
            },
        ]
    });
});
</script>
@endpush
