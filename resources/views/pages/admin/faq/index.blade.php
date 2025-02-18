@extends('layouts.admin')

@section('title', 'FAQ')

@section('content')
    <a href="{{ route('admin.faq.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data FAQ
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                    <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-warning">Edit</a>

                                    <a href="{{ route('admin.faq.show', $faq->id) }}" class="btn btn-info">Show</a>

                                    <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST"
                                        class="d-inline">
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
    </div>;
@endsection
