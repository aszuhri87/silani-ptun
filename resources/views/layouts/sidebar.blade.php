<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow border-right" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#"><span class="brand-logo">
                        <img src="{{ asset('app-assets/images/logo.png') }}" alt=""
                            style="width:90%; height:75%; padding-left:10%">
                    </span>
                    <h2 class="brand-text text-success">SILANI</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            @hasrole('admin|super admin')
                <li class=" nav-item nav-pill-success @if (Request::is('admin/dashboard')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/dashboard"><i data-feather="home"></i><span
                            class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
                </li>
            @endhasrole
            @role('applicant')
                <li class=" nav-item nav-pill-success  @if (Request::is('applicant/dashboard')) active @endif"><a
                        class="d-flex align-items-center" href="/applicant/dashboard"><i data-feather="home"></i><span
                            class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
                </li>
            @endrole
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Internal</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @role('super admin')
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather="database"></i><span class="menu-title text-truncate"
                            data-i18n="Menu Levels">Master Data</span></a>
                    <ul class="menu-content">
                        <li class="nav-item @if (Request::is('admin/unit')) active @endif"><a
                                class="d-flex align-items-center" href="/admin/unit"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Second Level">Unit Bidang</span></a>
                        </li>
                        <li class="nav-item @if (Request::is('admin/sub-unit')) active @endif"><a
                                class="d-flex align-items-center" href="/admin/sub-unit"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Second Level">Sub Unit/Bidang</span></a>
                        </li>
                    </ul>
                </li>
            @endrole

            @role('applicant')

                @if (Auth::user()->category == 'umum')
                    <li class="nav-item @if (Request::is('applicant/document')) active @endif"><a
                            class="d-flex align-items-center" href="/applicant/document"><i
                                data-feather="file-plus"></i><span class="menu-item text-truncate"
                                data-i18n="Second Level">Buat Dokumen</span></a>
                    <li class="nav-item @if (Request::is('applicant/verification-process')) active @endif"><a
                            class="d-flex align-items-center" href="/applicant/verification-process" data-toggle="tooltip"
                            data-bs-placement="right" title="Perizinan Dokumen"><i data-feather="edit-3"></i><span
                                class="menu-title text-truncate">Perizinan Dokumen</span></span><span
                                class="ml-1 proceed_count badge bg-secondary"> {{ $proceed }} </span> </a>
                    </li>

                    <li class="nav-item @if (Request::is('applicant/done-docs')) active @endif"><a
                            class="d-flex align-items-center" href="/applicant/done-docs"><i
                                data-feather="check-square"></i><span class="menu-title text-truncate mr-3"
                                style="margin-left: 2px;" data-i18n="Todo">Selesai
                            </span><span class="ml-3 done_count badge bg-secondary"> {{ $done }} </span></a>
                    </li>
                @endif

                @if (Auth::user()->category == 'karyawan')
                    @if (Auth::user()->title == 'Ketua' ||
                            Auth::user()->title == 'Wakil Ketua' ||
                            Auth::user()->title == 'Sekretaris' ||
                            Auth::user()->title == 'Panitera' ||
                            Auth::user()->title == 'Panitera Muda Hukum' ||
                            Auth::user()->title == 'Panitera Muda Perkara' ||
                            Auth::user()->title == 'Panitera Muda Hukum' ||
                            Auth::user()->title == 'Kasub Umum dan Keuangan' ||
                            Auth::user()->title == 'Kasub Kepegawaian, Ortala' ||
                            Auth::user()->title == 'Kasub Perencanaan, TI dan Pelaporan')
                        <li class="nav-item @if (Request::is('applicant/disposition-document')) active @endif"><a
                                class="d-flex align-items-center" href="/applicant/disposition-document"><i
                                    data-feather="list"></i><span class="menu-title text-truncate"
                                    style="margin-left: 2px;">Lembar Disposisi
                                    <span
                                        class="disposition_count badge bg-secondary">{{ $disposition_count }}</span></span></a>
                        </li>
                    @endif

                    <li class="nav-item @if (Request::is('applicant/outgoing-letter')) active @endif"><a
                            class="d-flex align-items-center" href="/applicant/outgoing-letter"><i
                                data-feather="arrow-up-circle"></i><span class="mr-3 menu-title text-truncate"
                                style="margin-left: 2px;">Surat Keluar </span>
                            <span class="outgoing_count badge bg-secondary">{{ $outgoing_count }}</span></a>
                    </li>

                    <li class="nav-item @if (Request::is('applicant/leave-document')) active @endif"><a
                            class="d-flex align-items-center" href="/applicant/leave-document"><i
                                data-feather="film"></i><span class="menu-title text-truncate mr-1" data-i18n="Todo"
                                style="margin-left: 2px;">Perizinan Cuti </span><span
                                class="ml-1 leave_count badge bg-secondary">
                                {{ $leave_count }}</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('applicant/exit-permit-document')) active @endif"><a
                            class="d-flex align-items-center" href="/applicant/exit-permit-document"
                            data-toggle="tooltip" data-bs-placement="right" title="Perizinan Keluar Kantor"><i
                                data-feather="arrow-right-circle"></i><span class="menu-title text-truncate"
                                data-i18n="Todo">Perizinan Keluar Kantor</span><span
                                class="exit_count badge bg-secondary">
                                {{ $exit_count }}</span></a>
                    </li>
                @endif
            @endrole

            @hasrole('admin')
                @if ($admin_kepeg == true)
                    @if (Auth::user())
                        <li class="nav-item @if (Request::is('admin/leave-document')) active @endif"><a
                                class="d-flex align-items-center" href="/admin/leave-document"><i
                                    data-feather="film"></i><span class="menu-title text-truncate mr-1" data-i18n="Todo"
                                    style="margin-left: 2px;">Perizinan Cuti </span><span
                                    class="ml-1 leave_count badge bg-secondary">
                                    {{ $leave_count }}</span></a>
                        </li>
                        <li class="nav-item @if (Request::is('admin/exit-permit-document')) active @endif"><a
                                class="d-flex align-items-center" href="/admin/exit-permit-document"
                                data-toggle="tooltip" data-bs-placement="right" title="Perizinan Keluar Kantor"><i
                                    data-feather="arrow-right-circle"></i><span class="menu-title text-truncate"
                                    data-i18n="Todo">Perizinan Keluar Kantor</span><span
                                    class="exit_count badge bg-secondary">
                                    {{ $exit_count }}</span></a>
                        </li>
                    @endif
                @endif

                @if ($admin_surat == true)
                    <li class="nav-item @if (Request::is('admin/disposition-document')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/disposition-document"><i
                                data-feather="list"></i><span class="menu-title text-truncate"
                                style="margin-left: 2px;">Lembar Disposisi
                                <span
                                    class="disposition_count badge bg-secondary">{{ $disposition_count }}</span></span></a>
                    </li>

                    <li class="nav-item @if (Request::is('admin/outgoing-letter')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/outgoing-letter"><i
                                data-feather="arrow-up-circle"></i><span class="mr-3 menu-title text-truncate"
                                style="margin-left: 2px;">Surat Keluar </span>
                            <span class="outgoing_count badge bg-secondary">{{ $outgoing_count }}</span></a>
                    </li>

                    <li class=" navigation-header"><span data-i18n="Dokumen Umum ">Dokumen Umum</span><i
                            data-feather="more-horizontal"></i>

                    <li class="nav-item @if (Request::is('admin/inbox')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/inbox"><i data-feather="inbox"></i><span
                                class="menu-title text-truncate" data-i18n="Chat">Dokumen Masuk
                                <span class="inbox_count badge bg-secondary"> {{ $inbox }} </span></span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/verification')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/verification" data-toggle="tooltip"
                            data-bs-placement="right" title="Perizinan Dokumen"><i data-feather="edit-3"></i><span
                                class="menu-title text-truncate">Perizinan Dokumen</span></span><span
                                class="ml-1 proceed_count badge bg-secondary"> {{ $proceed }} </span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/accepted')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/accepted"><i
                                data-feather="check-square"></i><span class="menu-title text-truncate mr-3"
                                style="margin-left: 2px;" data-i18n="Todo">Selesai
                            </span><span class="ml-3 done_count badge bg-secondary"> {{ $done }} </span></a>
                    </li>
                @endif


            @endhasrole

            @hasrole('super admin')

                <li class="nav-item @if (Request::is('admin/disposition-document')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/disposition-document"><i
                            data-feather="list"></i><span class="menu-title text-truncate"
                            style="margin-left: 2px;">Lembar Disposisi
                            <span class="disposition_count badge bg-secondary">{{ $disposition_count }}</span></span></a>

                </li>


                <li class="nav-item @if (Request::is('admin/outgoing-letter')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/outgoing-letter"><i
                            data-feather="arrow-up-circle"></i><span class="mr-3 menu-title text-truncate"
                            style="margin-left: 2px;">Surat Keluar </span>
                        <span class="outgoing_count badge bg-secondary">{{ $outgoing_count }}</span></a>
                </li>

                @if (Auth::user())
                    <li class="nav-item @if (Request::is('admin/leave-document')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/leave-document"><i
                                data-feather="film"></i><span class="menu-title text-truncate mr-1" data-i18n="Todo"
                                style="margin-left: 2px;">Perizinan Cuti </span><span
                                class="ml-1 leave_count badge bg-secondary">
                                {{ $leave_count }}</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/exit-permit-document')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/exit-permit-document" data-toggle="tooltip"
                            data-bs-placement="right" title="Perizinan Keluar Kantor"><i
                                data-feather="arrow-right-circle"></i><span class="menu-title text-truncate"
                                data-i18n="Todo">Perizinan Keluar Kantor</span><span
                                class="exit_count badge bg-secondary">
                                {{ $exit_count }}</span></a>
                    </li>
                @endif

                <li class=" navigation-header"><span data-i18n="Dokumen Umum ">Dokumen Umum</span><i
                        data-feather="more-horizontal"></i>

                <li class="nav-item @if (Request::is('admin/inbox')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/inbox"><i data-feather="inbox"></i><span
                            class="menu-title text-truncate" data-i18n="Chat">Dokumen Masuk
                            <span class="inbox_count badge bg-secondary"> {{ $inbox }} </span></span></a>
                </li>

                <li class="nav-item @if (Request::is('admin/verification')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/verification" data-toggle="tooltip"
                        data-bs-placement="right" title="Perizinan Dokumen"><i data-feather="edit-3"></i><span
                            class="menu-title text-truncate">Perizinan Dokumen</span></span><span
                            class="ml-1 proceed_count badge bg-secondary"> {{ $proceed }} </span></a>
                </li>

                <li class="nav-item @if (Request::is('admin/accepted')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/accepted"><i data-feather="check-square"></i><span
                            class="menu-title text-truncate mr-3" style="margin-left: 2px;" data-i18n="Todo">Selesai
                        </span><span class="ml-3 done_count badge bg-secondary"> {{ $done }} </span></a>
                </li>
            @endhasrole

            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Akun &amp; Data</span><i
                    data-feather="more-horizontal"></i>

                @hasrole('admin|super admin')
                <li class="nav-item @if (Request::is('admin/profile')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/profile"><i data-feather="user"></i><span
                            class="menu-title text-truncate" data-i18n="Documentation">Profile</span></a>
                </li>
            @endhasrole

            @role('applicant')
                <li class="nav-item @if (Request::is('applicant/profile')) active @endif"><a
                        class="d-flex align-items-center" href="/applicant/profile"><i data-feather="user"></i><span
                            class="menu-title text-truncate" data-i18n="Documentation">Profile</span></a>
                </li>
            @endrole

            @role('super admin')
                <li class="nav-item @if (Request::is('admin/manage-admin')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/manage-admin"><i
                            data-feather="user-plus"></i><span class="menu-title text-truncate"
                            data-i18n="Documentation">Manajemen Admin</span></a>
                </li>

                <li class="nav-item @if (Request::is('admin/list-applicant')) active @endif"><a
                        class="d-flex align-items-center" href="/admin/list-applicant" data-toggle="tooltip"
                        data-bs-placement="right" title="Karyawan"><i data-feather="users"></i><span
                            class="menu-item text-truncate" data-i18n="Second Level">Daftar Karyawan</span></a>
                </li>

                <li class="nav-item @if (Request::is('admin/list-general-applicant')) active @endif"><a
                    class="d-flex align-items-center" href="/admin/list-general-applicant" data-toggle="tooltip"
                    data-bs-placement="right" title="Daftar Pemohon Umum"><i data-feather="users"></i><span
                        class="menu-item text-truncate" data-i18n="Second Level">Daftar Pemohon Umum</span></a>
                </li>
            @endrole

            @role('admin')
                @if ($admin_kepeg == true)
                    <li class="nav-item @if (Request::is('admin/list-applicant')) active @endif"><a
                            class="d-flex align-items-center" href="/admin/list-applicant" data-toggle="tooltip"
                            data-bs-placement="right" title="Karyawan"><i data-feather="users"></i><span
                                class="menu-item text-truncate" data-i18n="Second Level">Daftar Karyawan</span></a>
                    </li>
                @endif

                <li class="nav-item @if (Request::is('admin/list-general-applicant')) active @endif"><a
                    class="d-flex align-items-center" href="/admin/list-general-applicant" data-toggle="tooltip"
                    data-bs-placement="right" title="Daftar Pemohon Umum"><i data-feather="users"></i><span
                        class="menu-item text-truncate" data-i18n="Second Level">Daftar Pemohon Umum</span></a>
                </li>
            @endrole


            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('logout') }}"><i
                        data-feather="log-out"></i><span class="menu-title text-truncate"
                        data-i18n="Raise Support">Logout</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
