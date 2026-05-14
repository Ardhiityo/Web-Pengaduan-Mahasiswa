@extends('layouts.admin')

@section('title', 'Data Kategori')

@section('content')
    <a href="{{ route('admin.report-category.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Ikon</th>
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
            $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.report-category.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name',        name: 'name' },
                    { data: 'image',       name: 'image', orderable: false, searchable: false },
                    { data: 'action',      name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
