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
                <!-- Dashboard Ecommerce Starts -->
                {{-- <section id="dashboard-ecommerce"> --}}
                    {{-- <div class="row match-height"> --}}

                        <!--/ Medal Card -->

                        <!-- Statistics Card -->
                        <div class="col-xl-12 col-md-6 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Statistics</h4>
                                    <div class="d-flex align-items-center">
                                        <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p>
                                    </div>
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
                                                    <h4 class="font-weight-bolder mb-0">230k</h4>
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
                                                    <h4 class="font-weight-bolder mb-0">8.549k</h4>
                                                    <p class="card-text font-small-3 mb-0">Pemohon</p>
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
                                                    <h4 class="font-weight-bolder mb-0">1.423k</h4>
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
                                                    <h4 class="font-weight-bolder mb-0">9745</h4>
                                                    <p class="card-text font-small-3 mb-0">Surat Diterima</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    {{-- </div> --}}

                      <!-- apex charts section start -->
                    <section id="apexchart">
                        <div class="row">
                            <!-- Area Chart starts -->
                            <div class="col-xl-12 col-md-6 col-12"">
                                <div class="card">
                                    <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                                        <div>
                                            <h4 class="card-title">Line Chart</h4>
                                            <span class="card-subtitle text-muted">Commercial networks</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="font-medium-2" data-feather="calendar"></i>
                                            <input type="text" class="form-control flat-picker bg-transparent border-0 shadow-none" placeholder="YYYY-MM-DD" />
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="line-area-chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Area Chart ends -->
                            <!-- Apex charts section end -->
                        </div>
                    </section>

                    {{-- <div class="row match-height">

                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-8 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Category</th>
                                                    <th>Views</th>
                                                    <th>Revenue</th>
                                                    <th>Sales</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                {{-- <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar rounded">
                                                                <div class="avatar-content">
                                                                    <img src="../../../app-assets/images/icons/parachute.svg" alt="Parachute svg" />
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bolder">Motels</div>
                                                                <div class="font-small-2 text-muted">vecav@hodzi.co.uk</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-light-success mr-1">
                                                                <div class="avatar-content">
                                                                    <i data-feather="coffee" class="font-medium-3"></i>
                                                                </div>
                                                            </div>
                                                            <span>Grocery</span>
                                                        </div>
                                                    </td>

                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!--/ Company Table Card -->



                    </div>
                {{-- </section> --}}
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('script')
    {{-- @include('admin.script') --}}
@endpush
