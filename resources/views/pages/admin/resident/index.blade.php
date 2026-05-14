@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
    <a href="{{ route('admin.resident.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="residentsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Foto Profil</th>
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
            $('#residentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.resident.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name',         name: 'name' },
                    { data: 'nim',          name: 'nim' },
                    { data: 'email',        name: 'email' },
                    { data: 'study_program', name: 'study_program' },
                    { data: 'avatar',       name: 'avatar', orderable: false, searchable: false },
                    { data: 'action',       name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
