@extends('layouts.admin')

@section('title', 'Data FAQ')

@section('content')
    <a href="{{ route('admin.faq.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data FAQ
            </h6>
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
                    <tbody>
                        @foreach ($faqs as $faq)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $faq->title }}</td>
                                <td>{{ $faq->description }}</td>
                                <td>
                                    <a href="{{ route('admin.faq.show', ['faq' => $faq->id]) }}"
                                        class="my-1 btn btn-info btn-sm">Show</a>

                                    <a href="{{ route('admin.faq.edit', ['faq' => $faq->id]) }}"
                                        class="my-1 btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('admin.faq.destroy', ['faq' => $faq->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const table = $('#faqsTable').DataTable({
                pageLength: {{ request('per_page', 10) }},
                search: {
                    search: '{{ request('search') }}'
                }
            });

            // change per page
            table.on('length.dt', function () {
                const perPage = table.page.len();
                const search = table.search();
                window.location.href =
                    `?per_page=${perPage}&search=${search}`;
            });

            // debounce search
            let timeout = null;

            $('#faqsTable_filter input').on('keyup', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const perPage = table.page.len();
                    const search = this.value;
                    window.location.href =
                        `?per_page=${perPage}&search=${search}`;
                }, 1000);
            });
        });
    </script>
@endpush
