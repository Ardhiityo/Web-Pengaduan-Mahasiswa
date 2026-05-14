@extends('layouts.admin')

@section('title', 'Data Admin')

@section('content')
    <a href="{{ route('admin.admin.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Admin</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="adminsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#adminsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.admin.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name',      name: 'name' },
                    { data: 'email',     name: 'email' },
                    { data: 'faculties', name: 'faculties' },
                    { data: 'action',    name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
