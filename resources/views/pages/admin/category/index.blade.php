@extends('layouts.admin')

@section('title', 'Data Kategori')

@section('content')
    <a href="{{ route('admin.report-category.create') }}" class="mb-3 btn btn-primary">
        Tambah Data</a>

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
                            <th>Kategori </th>
                            <th>Ikon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportCategories as $reportCategory)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $reportCategory->name }}</td>
                                <td>
                                    @if ($reportCategory->image)
                                        <img src="{{ asset('storage/' . $reportCategory->image) }}" alt="image"
                                            width="100">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.report-category.show', ['report_category' => $reportCategory->id]) }}"
                                        class="my-1 btn btn-sm btn-info">Show</a>

                                    <a href="{{ route('admin.report-category.edit', ['report_category' => $reportCategory->id]) }}"
                                        class="my-1 btn btn-sm btn-warning">Edit</a>

                                    <form
                                        action="{{ route('admin.report-category.destroy', ['report_category' => $reportCategory->id]) }}"
                                        method="POST" class="d-inline">
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
            const table = $('#categoriesTable').DataTable({
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

            $('#categoriesTable_filter input').on('keyup', function () {
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
