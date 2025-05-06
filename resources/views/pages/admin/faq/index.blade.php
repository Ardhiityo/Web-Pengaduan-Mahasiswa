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
                                    <a href="{{ route('admin.faq.edit', Crypt::encrypt($faq->id)) }}"
                                        class="my-1 btn btn-warning btn-sm">Edit</a>

                                    <a href="{{ route('admin.faq.show', Crypt::encrypt($faq->id)) }}"
                                        class="my-1 btn btn-info btn-sm">Show</a>

                                    <form action="{{ route('admin.faq.destroy', Crypt::encrypt($faq->id)) }}" method="POST"
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
