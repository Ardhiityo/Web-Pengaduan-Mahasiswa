@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Dashboard</h1>
    </div>
    <div class="row">
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-dark text-uppercase">
                                Total Mahasiswa</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $totalResidents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @role('superadmin')
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-primary h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-dark text-uppercase">Total Admin
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="mr-3 mb-0 text-gray-800 h5 font-weight-bold">{{ $totalAdmins }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-user fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-dark text-uppercase">
                                Total kategori</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $totalReportCategories }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-layer-group fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-dark text-uppercase">Total Laporan
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="mr-3 mb-0 text-gray-800 h5 font-weight-bold">{{ $totalReports }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-dark text-uppercase">Total FAQ
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="mr-3 mb-0 text-gray-800 h5 font-weight-bold">{{ $totalFAQs }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-comments fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
