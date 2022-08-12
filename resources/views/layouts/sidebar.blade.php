<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow border-right" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#"><span class="brand-logo">
                         <img src="{{asset('app-assets/images/logo.png')}}" alt="" style="width:90%; height:75%; padding-left:10%" >
                    </span>
                        {{-- <img src="{{asset('app-assets/images/logo.png')}}" alt="" style="width:auto; height:80%" > --}}
                    <h2 class="brand-text text-success">SILANI</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            @hasrole('admin|super admin')
                <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/admin/dashboard"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
                </li>
            @endhasrole
            @role('applicant')
                <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/applicant/dashboard"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
                </li>
            @endrole
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps</span><i data-feather="more-horizontal"></i>
            </li>
            @role('super admin')
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Menu Levels">Master Data</span></a>
                <ul class="menu-content">
                    {{-- <li><a class="d-flex align-items-center" href="/applicant/mail"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level"></span></a> --}}
                    <li class="nav-item @if (Request::is('admin/unit')) active @endif"><a class="d-flex align-items-center" href="/admin/unit"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Unit Bidang</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/sub-unit')) active @endif"><a class="d-flex align-items-center" href="/admin/sub-unit"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Sub Unit/Bidang</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/document-category')) active @endif"><a class="d-flex align-items-center" href="/admin/document-category"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Dokumen Kategori</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/req-type')) active @endif"><a class="d-flex align-items-center" href="/admin/req-type"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Tipe Keperluan</span></a>
                    </li>
                    {{-- <li class="nav-item @if (Request::is('admin/document-req')) active @endif"><a class="d-flex align-items-center" href="/admin/document-req"  data-toggle="tooltip"  data-bs-placement="right" title="Keperluan Dokumen"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Keperluan Dokumen</span></a>
                    </li> --}}
                    <li class="nav-item @if (Request::is('admin/document-category-req')) active @endif"><a class="d-flex align-items-center" href="/admin/document-category-req"  data-toggle="tooltip" data-bs-placement="right" title="Kategori Keperluan Dokumen"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Kategori Keperluan Dokumen </span></a>
                    </li>
                </ul>
            </li>
            @endrole
            @role('admin')
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Menu Levels">Master Data</span></a>
                <ul class="menu-content">
                    <li class="nav-item @if (Request::is('admin/document-category')) active @endif"><a class="d-flex align-items-center" href="/admin/document-category"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Dokumen Kategori</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/req-type')) active @endif"><a class="d-flex align-items-center" href="/admin/req-type"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Tipe Keperluan</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/document-category-req')) active @endif"><a class="d-flex align-items-center" href="/admin/document-category-req"  data-toggle="tooltip" data-bs-placement="right" title="Kategori Keperluan Dokumen"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Kategori Keperluan Dokumen </span></a>
                    </li>
                </ul>
            </li>
            @endrole


            @hasrole('admin|super admin')
            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="/admin/notification"><i data-feather="bell"></i><span class="menu-title text-truncate" data-i18n="Chat">Notifikasi</span></a>
            </li> --}}
            @endhasrole

          @role('applicant')
            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="/applicant/notification"><i data-feather="bell"></i><span class="menu-title text-truncate" data-i18n="Chat">Notifikasi</span></a>
            </li> --}}
            <li class="nav-item @if (Request::is('applicant/document')) active @endif"><a class="d-flex align-items-center" href="/applicant/document"><i data-feather="file-plus"></i><span class="menu-item text-truncate" data-i18n="Second Level">Buat Dokumen</span></a>
            <li class="nav-item @if (Request::is('applicant/verification-process')) active @endif"><a class="d-flex align-items-center" href="/applicant/verification-process"><i data-feather="edit-3"></i><span class="menu-title text-truncate" >Perizinan Dokumen</span></a>
            </li>

            <li class="nav-item @if (Request::is('applicant/done-docs')) active @endif"><a class="d-flex align-items-center" href="/applicant/done-docs"><i data-feather="check-square"></i><span class="menu-title text-truncate" data-i18n="Todo">Selesai</span></a>
            </li>
           @endrole

           @hasrole('admin|super admin')
            <li class="nav-item @if (Request::is('admin/inbox')) active @endif"><a class="d-flex align-items-center" href="/admin/inbox"><i data-feather="inbox"></i><span class="menu-title text-truncate" data-i18n="Chat">Dokumen Masuk</span></a>
            </li>
            <li class="nav-item @if (Request::is('admin/verification')) active @endif"><a class="d-flex align-items-center" href="/admin/verification"><i data-feather="edit-3"></i><span class="menu-title text-truncate" >Perizinan Dokumen</span></a>
            </li>

            <li class="nav-item @if (Request::is('admin/accepted')) active @endif"><a class="d-flex align-items-center" href="/admin/accepted"><i data-feather="check-square"></i><span class="menu-title text-truncate" data-i18n="Todo">Selesai</span></a>
            </li>
            @endhasrole
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Akun &amp; Data</span><i data-feather="more-horizontal"></i>
          @hasrole('admin|super admin')
            <li class="nav-item @if (Request::is('admin/profile')) active @endif"><a class="d-flex align-items-center" href="/admin/profile"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Documentation">Profile</span></a>
            </li>
        @endhasrole
        @role('applicant')
            <li class="nav-item @if (Request::is('applicant/profile')) active @endif"><a class="d-flex align-items-center" href="/applicant/profile"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Documentation">Profile</span></a>
            </li>
          @endrole

          @role('super admin')
            <li class="nav-item @if (Request::is('admin/manage-admin')) active @endif"><a class="d-flex align-items-center" href="/admin/manage-admin"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Documentation">Manajemen Admin</span></a>
            </li>
            @endrole
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i data-feather="log-out"></i><span class="menu-title text-truncate" data-i18n="Raise Support">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
