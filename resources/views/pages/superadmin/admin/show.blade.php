@extends('layouts.admin')

@section('title', 'Detail Admin')


@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.admin.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail Admin</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Nama</td>
                    <td>{{ $admin->user->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $admin->user->email }}</td>
                </tr>
                <tr>
                    <td>Fakultas</td>
                    <td>{{ $admin->faculty->name }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
