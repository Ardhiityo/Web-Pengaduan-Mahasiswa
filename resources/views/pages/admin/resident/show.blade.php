@extends('layouts.admin')

@section('title', 'Detail Data Mahasiswa')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.resident.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail Mahasiswa</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Nama</td>
                    <td>{{ $resident->user->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $resident->user->email }}</td>
                </tr>
                <tr>
                    <td>Foto profil</td>
                    <td>
                        <img src="{{ asset('storage/' . $resident->avatar) }}" alt="avatar" width="200">
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
