@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @if (Auth::user()->category == 'umum')
                    <!-- Statistics Card -->
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">Statistik</h4>

                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <div class="media">
                                            <div class="avatar bg-light-primary mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="trending-up" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">{{ $queue }}</h4>
                                                <p class="card-text font-small-3 mb-0">Surat Masuk</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <div class="media">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="user" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">{{ $process }}</h4>
                                                <p class="card-text font-small-3 mb-0">Diproses</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <div class="media">
                                            <div class="avatar bg-light-danger mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="x-circle" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">{{ $reject }}</h4>
                                                <p class="card-text font-small-3 mb-0">Surat Ditolak</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12">
                                        <div class="media">
                                            <div class="avatar bg-light-success mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="check-circle" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">{{ $accept }}</h4>
                                                <p class="card-text font-small-3 mb-0">Surat Diterima</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics Card -->
                @endif

                <!-- apex charts section start -->
                @if (Auth::user()->category == 'karyawan')
                    <section id="apexchart">
                        <div class="row">
                            <!-- Area Chart starts -->
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class=" card">
                                    <div
                                        class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                                        <div>
                                            <h4 class="card-title">Total Dokumen Tahun {{ date('Y') }}</h4>
                                            <span class="card-subtitle text-muted">Dihitung berdasarkan bulan</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="karyawan-chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Area Chart ends -->
                            <!-- Apex charts section end -->
                        </div>
                    </section>
                @else
                    <!-- apex charts section start -->
                    <section id="apexchart">
                        <div class="row">
                            <!-- Area Chart starts -->
                            <div class="col-xl-12 col-md-12 col-12"">
                                <div class=" card">
                                    <div
                                        class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                                        <div>
                                            <h4 class="card-title">Total Dokumen Tahun {{ date('Y') }}</h4>
                                            <span class="card-subtitle text-muted">Dihitung berdasarkan bulan</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="applicant-chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Area Chart ends -->
                            <!-- Apex charts section end -->
                        </div>
                    </section>
                @endif

                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <!--/ Company Table Card -->
    </div>
    <!-- Dashboard Ecommerce ends -->
    </div>
    </div>
    </div>
    <!-- END: Content-->
@endsection

@push('script')
    @include('applicant.dashboard.script')
@endpush
