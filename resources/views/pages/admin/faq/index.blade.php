@extends('layouts.admin')

@section('title', 'Data FAQ')

@section('content')
    <a href="{{ route('admin.faq.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data FAQ</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="faqsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
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
            $('#faqsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.faq.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'title',       name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'action',      name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
