 <!-- BEGIN: Header-->
 <nav
     class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark bg-ptun navbar-shadow container-xxl">
     <div class="navbar-container d-flex content">
         <div class="bookmark-wrapper d-flex align-items-center">
             <ul class="nav navbar-nav d-xl-none">
                 <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                             data-feather="menu"></i></a></li>
             </ul>
             <ul class="nav navbar-nav bookmark-icons">
                 {{-- @hasrole('admin|super admin')
                     <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/admin/inbox" data-toggle="tooltip"
                             data-placement="top" title="Surat Masuk"><i class="ficon" data-feather="inbox"></i>  <span class="inbox_count badge"> {{ $inbox }} </span></a>
                            </li>
                     <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/admin/accepted" data-toggle="tooltip"
                             data-placement="top" title="Selesai"><i class="ficon" data-feather="check-square"></i> <span class="done_count badge"> {{ $done }} </span></a>
                     </li>
                 @endhasrole
                 @role('applicant')
                     <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/applicant/done-docs"
                             data-toggle="tooltip" data-placement="top" title="Selesai"><i class="ficon"
                                 data-feather="check-square"></i><span class="done_count badge"> {{ $done }} </span>
                                </a>
                     </li>
                 @endrole --}}
             </ul>
         </div>
         <ul class="nav navbar-nav align-items-center ml-auto">
             <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                     id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     @hasrole('admin|super admin|applicant')
                         <div class="user-nav d-sm-flex d-none"><span
                                 class="user-name font-weight-bolder">{{ Auth::user()->username }}</span><span
                                 class="user-status">
                             @endhasrole
                             @hasrole('admin')
                                 Admin

                                 @elserole ('super admin')
                                 Super Admin

                            @elserole('applicant')
                                @if (Auth::user()->category == 'karyawan')
                                    Pemohon Karyawan
                                @else
                                    Pemohon Umum
                                @endif
                            @endhasrole

                             @hasrole('applicant')
                                 @if (Auth::user()->join('applicants', 'applicants.user_id', 'users.id')->where('users.id', Auth::id())->first()->image != null)
                             </span></div><span class="avatar"><img class="round"
                                 src="{{ asset('/files/' .Auth::user()->join('applicants', 'applicants.user_id', 'users.id')->where('users.id', Auth::id())->first()->image) }}"
                                 alt="avatar" height="40" width="40"><span
                                 class="avatar-status-online"></span></span>
                     @else
                         </span>
         </div><span class="avatar"><img class="round" src="{{ asset('/files/profile.png') }}" alt="avatar"
                 height="40" width="40"><span class="avatar-status-online"></span></span>
         @endif
     @endhasrole

     @hasrole('admin|super admin')
         </span></div><span class="avatar"><img class="round" src="{{ asset('/app-assets/images/avatars/profile.png') }}"
                 alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
     @endhasrole
     </a>
     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
         @role('applicant')
             <a class="dropdown-item" href="/applicant/profile"><i class="mr-50" data-feather="user"></i> Profile</a>
             {{-- <a class="dropdown-item" href="/applicant/done-docs"><i class="mr-50" data-feather="check-square"></i>
                 Selesai</a> --}}
         @endrole
         @hasrole('admin|super admin')
             <a class="dropdown-item" href="/admin/profile"><i class="mr-50" data-feather="user"></i> Profile</a>
             {{-- <a class="dropdown-item" href="/admin/inbox"><i class="mr-50" data-feather="mail"></i> Surat Masuk</a>
             <a class="dropdown-item" href="/admin/accepted"><i class="mr-50" data-feather="check-square"></i> Selesai</a> --}}
         @endhasrole
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i
                 class="mr-50" data-feather="log-out"></i> Logout</a>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
             @csrf
         </form>
     </div>
     </li>
     </ul>
     </div>
 </nav>
 <!-- END: Header-->

 @include('layouts.sidebar')
