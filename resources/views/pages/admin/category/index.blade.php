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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                    <a href="{{ route('admin.report-category.edit', Crypt::encrypt($reportCategory->id)) }}"
                                        class="btn btn-warning">Edit</a>

                                    <a href="{{ route('admin.report-category.show', Crypt::encrypt($reportCategory->id)) }}"
                                        class="btn btn-info">Show</a>

                                    <form
                                        action="{{ route('admin.report-category.destroy', Crypt::encrypt($reportCategory->id)) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
