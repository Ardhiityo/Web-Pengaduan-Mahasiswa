@extends('layouts.admin')

@section('title', 'Detail FAQ')


@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.faq.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail FAQ</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Judul</td>
                    <td>{{ $faq->title }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>{{ $faq->description }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
