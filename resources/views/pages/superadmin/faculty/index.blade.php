@extends('layouts.admin')

@section('title', 'Data Fakultas')

@section('content')
    <a href="{{ route('admin.faculty.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Fakultas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="facultiesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
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
            $('#facultiesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.faculty.index') }}',
                columns: [
                    { data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name',         name: 'name' },
                    { data: 'study_programs', name: 'study_programs' },
                    { data: 'action',       name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
