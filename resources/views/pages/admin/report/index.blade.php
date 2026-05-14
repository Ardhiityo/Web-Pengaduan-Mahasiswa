@extends('layouts.admin')

@section('title', 'Data Laporan')

@section('content')
    <a href="{{ route('admin.report.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Laporan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="reportsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Kategori</th>
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
            $('#reportsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.report.index') }}',
                columns: [
                    { data: 'DT_RowIndex',       name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'code',              name: 'code' },
                    { data: 'title',             name: 'title' },
                    { data: 'resident_name',     name: 'resident_name' },
                    { data: 'category_name',     name: 'category_name' },
                    { data: 'study_program_name', name: 'study_program_name' },
                    { data: 'action',            name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
