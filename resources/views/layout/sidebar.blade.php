<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            @if (setting()->logo)
                <img src="/upload/{{ setting()->logo }}" alt="" width="80px">    
            @endif
            <img src="/upload/default.png" alt="" width="80px">
        </div>
        <div class="sidebar-brand-text">{{ setting()->name_short }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pathology
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @if (userHasPermission('patient-module'))
    <li class="nav-item">
        <a class="nav-link {{Request::is('patient*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Patient</span>
        </a>
        <div id="collapseTwo" class="collapse {{Request::is('patient*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if (userHasPermission('patient-store'))
                <a class="collapse-item {{Request::is('patient/create')?'active':''}}" href="{{ route('pathology.patient.create') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Add Patient</a>
                @endif
                @if (userHasPermission('patient-index'))
                <a class="collapse-item {{Request::is('patient/')?'active':''}}" href="{{ route('pathology.patient.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Patient List</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    @if (userHasPermission('pathology-module'))
    <li class="nav-item">
        <a class="nav-link {{Request::is('pathology*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#pathology"
            aria-expanded="true" aria-controls="pathology">
            <i class="fas fa-fw fa-users"></i>
            <span>Pathology</span>
        </a>
        <div id="pathology" class="collapse {{Request::is('pathology*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/report')?'active':''}}" href="{{ route('report_set.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Pathology List</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/report-view')?'active':''}}" href="{{ route('report_set.view') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Pathology Report</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/test')?'active':''}}" href="{{ route('test.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Test</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/tube')?'active':''}}" href="{{ route('tube.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Tube</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/unit')?'active':''}}" href="{{ route('pathology.unit.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Unit</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/result-name')?'active':''}}" href="{{ route('pathology.result_name.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Result Name</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/result-heading')?'active':''}}" href="{{ route('pathology.result_heading.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Result Heading</a>
                @endif
                @if (userHasPermission('pathology_test-index'))
                <a class="collapse-item {{Request::is('pathology/test-setup/create')?'active':''}}" href="{{ route('pathology.test_setup.create') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Add Pathology Setup</a>
                <a class="collapse-item {{Request::is('pathology/test-setup')?'active':''}}" href="{{ route('pathology.test_setup.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Pathology Setup List</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    @if (userHasPermission('doctor-module'))
    <li class="nav-item">
        <a class="nav-link {{Request::is('doctor*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#doctorMenu"
            aria-expanded="true" aria-controls="doctorMenu">
            <i class="fas fa-fw fa-users"></i>
            <span>Doctor</span>
        </a>
        <div id="doctorMenu" class="collapse {{Request::is('doctor*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if (userHasPermission('doctor-store'))
                <a class="collapse-item {{Request::is('doctor/create')?'active':''}}" href="{{ route('doctor.create') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Add Doctor</a>
                @endif
                @if (userHasPermission('doctor-index'))
                <a class="collapse-item {{Request::is('doctor')?'active':''}}" href="{{ route('doctor.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Doctor List</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    @if (userHasPermission('referral-module'))
    <li class="nav-item">
        <a class="nav-link {{Request::is('referral*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#referralMenu"
            aria-expanded="true" aria-controls="referralMenu">
            <i class="fas fa-fw fa-users"></i>
            <span>Referral</span>
        </a>
        <div id="referralMenu" class="collapse {{Request::is('referral*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if (userHasPermission('referral-store'))
                <a class="collapse-item {{Request::is('referral/create')?'active':''}}" href="{{ route('referral.create') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Add Referral</a>
                @endif
                @if (userHasPermission('referral-index'))
                <a class="collapse-item {{Request::is('referral')?'active':''}}" href="{{ route('referral.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Referral List</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    @if (userHasPermission('referral-module'))
    <li class="nav-item">
        <a class="nav-link {{Request::is('finance*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#financeMenu"
            aria-expanded="true" aria-controls="financeMenu">
            <i class="fas fa-fw fa-users"></i>
            <span>Finance</span>
        </a>
        <div id="financeMenu" class="collapse {{Request::is('finance*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if (userHasPermission('referral-store'))
                <a class="collapse-item {{Request::is('finance/due_collection')?'active':''}}" href="{{ route('due_collection.index') }}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Due Collection</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    <!-- Nav Item - Pages Collapse Menu -->
    @if (userHasPermission('setting-index') || Auth::user()->id == 1 )
    <li class="nav-item">
        <a class="nav-link {{Request::is('setting*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Setting</span>
        </a>
        <div id="collapsePages" class="collapse {{Request::is('setting*')?'show':''}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('setting/role')?'active':''}}" href="{{ route('role.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Role</a>
                @if (userHasPermission('user-index'))
                <a class="collapse-item {{Request::is('setting/user')?'active':''}}" href="{{ route('user.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>User</a>
                @endif
                <a class="collapse-item {{Request::is('setting/site_setting')?'active':''}}" href="{{ route('site_setting.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Site Setting</a>
            </div>
        </div>
    </li>
    @endif
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->