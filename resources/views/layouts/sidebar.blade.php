<ul>
    <li class="menu-divider">Main</li>
    <li>
        <a class="{{ isRouteNameActive('adminDashboard') }}" href="{{route('adminDashboard')}}">
            <span class="nav-link-icon">
                <i class="bi bi-house-door"></i>
            </span>
            <span>Dashboard</span>
        </a>
        @can('view users')
        <a class="{{ isRouteActive('/users') }}" href="{{route('users.allUsers')}}">
            <span class="nav-link-icon">
                <i class="bi bi-person"></i>
            </span>
            <span>Users</span>
        </a>
        @endcan
        @can('view today company attendance')
        <a href="{{route('attendance.companyAttendance')}}" class="{{ isRouteNameActive('attendance.companyAttendance') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar-plus"></i>
            </span>
            <span>Company's Attendance</span>
        </a>
        @endcan
        @can('company leaves')
        <a href="{{route('leaves.companyLeaves')}}" class="{{ isRouteActive('leaves.companyLeaves') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar-plus"></i>
            </span>
            <span>Company's Leave</span>
        </a>
        @endcan
        @can('payroll')
        <a href="{{route('payroll.allPayrolls')}}" class="{{ isRouteActive('/payroll') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar-plus"></i>
            </span>
            <span>Payroll</span>
        </a>
        @endcan
        @can('lead leaves')
        <a href="{{route('leaves.leadLeaves')}}" class="{{ isRouteActive('leaves.leadLeaves') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar-plus"></i>
            </span>
            <span>Team's Leaves Requests</span>
        </a>
        @endcan
        <a href="{{route('attendance.userAttendance',['id'=>auth()->user()->id,'month'=>date('m'),'year'=>date('Y')])}}" class="{{ isRouteNameActive('attendance.userAttendance') }}">
            <span class="nav-link-icon">
                <i class="bi bi-clock"></i>
            </span>
            <span>My Attendance</span>
        </a>
        <a href="{{route('discrepancy.allDiscrepancy')}}" class="{{ isRouteActive('/discrepancy') }}">
            <span class="nav-link-icon">
                <i class="bi bi-arrow-repeat"></i>
            </span>
            <span>Discrepancies</span>
        </a>
        <a href="{{route('leaves.showLeaves')}}" class="{{ isRouteActive('/leaves') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar-plus"></i>
            </span>
            <span>My Leave Request</span>
        </a>
        @can('show work from home')
        <a href="{{route('workfromhome.allWorkFromHome')}}" >
            <span class="nav-link-icon">
                <i class="bi bi-house-door"></i>
            </span>
            <span>Work From Home</span>
        </a>
        @endcan
        @can('view finances')
        <a href="{{route('finance.expenses',['month'=>date('m'),'year'=>date('Y')])}}" class="{{ isRouteActive('/finance') }}">
            <span class="nav-link-icon">
                <i class="bi bi-wallet2"></i>
            </span>
            <span>Finance</span>
        </a>
        @endcan
        @can('view fleet')
        <a href="{{route('fleet.allFleet')}}" class="{{ isRouteNameActive('fleet.allFleet') }}">
            <span class="nav-link-icon">
                <i class="bi bi-truck"></i>
            </span>
            <span>Fleets</span>
        </a>
        @endcan
        @can('fleet maintainance requests')
        <a href="{{route('fleet.MaintainanceRequests')}}" class="{{ isRouteNameActive('fleet.MaintainanceRequests') }}">
            <span class="nav-link-icon">
                <i class="bi bi-wrench"></i>
            </span>
            <span>Maintainance Requests</span>
        </a>
        @endcan
        @can('add announcement')
        <li class="open">
            <a href="#" target="_blank">
                <span class="nav-link-icon">
                    <i class="bi bi-megaphone"></i>
                </span>
                <span>Announcement</span></a>
            <ul style="display: none;">
                <!--@can('add unit announcement')-->
                <!--<li>-->
                <!--    <a href="{{route('announcements.unitAnnouncements')}}" class="{{ isRouteNameActive('announcements.unitAnnouncements') }}">-->
                <!--        <span class="nav-link-icon">-->
                <!--            <i class="bi bi-megaphone"></i>-->
                <!--        </span>-->
                <!--        <span>Unit</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--@endcan-->
                <!--@can('add team announcement')-->
                <!--<li>-->
                <!--    <a href="{{route('announcements.teamAnnouncements')}}" class="{{ isRouteNameActive('announcements.teamAnnouncements') }}">-->
                <!--        <span class="nav-link-icon">-->
                <!--            <i class="bi bi-megaphone"></i>-->
                <!--        </span>-->
                <!--        <span>Team</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--@endcan-->
                @can('add company announcement')
                <li>
                    <a href="{{route('announcements.companyAnnouncements')}}" class="{{ isRouteNameActive('announcements.companyAnnouncements') }}">
                        <span class="nav-link-icon">
                            <i class="bi bi-megaphone"></i>
                        </span>
                        <span>Company</span>
                    </a>
                </li>
                @endcan
                <!--@can('add depart announcement')-->
                <!--<li>-->
                <!--    <a href="{{route('announcements.departAnnouncements')}}" class="{{ isRouteNameActive('announcements.departAnnouncements') }}">-->
                <!--        <span class="nav-link-icon">-->
                <!--            <i class="bi bi-megaphone"></i>-->
                <!--        </span>-->
                <!--        <span>Department</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--@endcan-->
            </ul>
        </li>
        @endcan
    </li>

    @can('view leads')
    <li class="menu-divider">Sales Force</li>
    <li>

        <a href="{{route('lead.allLeads')}}" class="{{ isRouteActive('/salesforce/leads') }}">
            <span class="nav-link-icon">
                <i class="bi bi-telephone-inbound"></i>
            </span>
            <span>Leads</span>
        </a>
    </li>
    @endcan
    @can('view opportunities')
    <li>
        <a href="{{route('opportunity.allOpportunities')}}" class="{{ isRouteActive('/salesforce/opportunities') }}">
            <span class="nav-link-icon">
                <i class="bi bi-briefcase"></i>
            </span>
            <span>Opportunities</span>
        </a>
    </li>
    @endcan
    @can('view brands')
    <li class="menu-divider">Marketing</li>
    <li>
        <a href="{{route('brands.allBrands')}}" class="{{ isRouteActive('/marketing/brands') }}">
            <span class="nav-link-icon">
                <i class="bi bi-building"></i>
            </span>
            <span>Brands</span>
        </a>
    </li>
    @endcan
    @can('view packages')
    <li>
        <a href="{{route('packages.allPackages')}}" class="{{ isRouteActive('/marketing/packages') }}">
            <span class="nav-link-icon">
                <i class="bi bi-box"></i>
            </span>
            <span>Packages</span>
        </a>
    </li>
    @endcan
    @can('view projects')
    <li class="menu-divider">Collateral</li>

    <li>

        <a href="{{route('projects.allProjects')}}" class="{{ isRouteActive('/projects') }}">
            <span class="nav-link-icon">
                <i class="bi bi-kanban-fill"></i>
            </span>
            <span>Projects</span>
        </a>
    </li>
    @endcan
    <li class="menu-divider">Settings</li>
    <li>
        <a href="{{route('profile.myProfile')}}" class="{{ isRouteActive('/profile') }}">
            <span class="nav-link-icon">
                <i class="bi bi-person-lines-fill"></i>
            </span>
            <span>My Profile</span>
        </a>
    </li>
    <li>
        <a href="{{route('fleet.myFleet')}}" class="{{ isRouteNameActive('fleet.myFleet') }}">
            <span class="nav-link-icon">
                <i class="bi bi-truck"></i>
            </span>
            <span>My Fleet</span>
        </a>
    </li>


    @can('view companies')
    <li>
        <a href="{{route('admin.allCompanies')}}" class="{{ isRouteNameActive('admin.allCompanies') }}">
            <span class="nav-link-icon">
                <i class="bi bi-building"></i>
            </span>
            <span>Companies</span>
        </a>
    </li>
    @endcan
    @can('view units')
    <li>
        <a href="{{route('admin.allUnits')}}" class="{{ isRouteNameActive('admin.allUnits') }}">
            <span class="nav-link-icon">
                <i class="bi bi-bezier"></i>
            </span>
            <span>Units</span>
        </a>
    </li>
    @endcan
    @can('view department')
    <li>
        <a href="{{route('admin.allDeparts')}}" class="{{ isRouteNameActive('admin.allDeparts') }}">
            <span class="nav-link-icon">
                <i class="bi bi-command"></i>
            </span>
            <span>Departments</span>
        </a>
    </li>
    @endcan
    @can('view teams')
    <li>
        <a href="{{route('admin.allTeams')}}" class="{{ isRouteNameActive('admin.allTeams') }}">
            <span class="nav-link-icon">
                <i class="bi bi-people"></i>
            </span>
            <span>Teams</span>
        </a>
    </li>
    @endcan
    @can('view shifts')
    <li>
        <a href="{{route('shifts.allShifts')}}" class="{{ isRouteActive('shifts.allShifts') }}">
            <span class="nav-link-icon">
                <i class="bi bi-clock"></i>
            </span>
            <span>Shifts</span>
        </a>
    </li>
    @endcan
    <!--<li>-->
    <!--    <a  -->
    <!--        href="{{route('admin.teamChart',1)}}">-->
    <!--        <span class="nav-link-icon">-->
    <!--            <i class="bi bi-people"></i>-->
    <!--        </span>-->
    <!--        <span>My Team</span>-->
    <!--    </a>-->
    <!--</li>-->
    @can('roles and permissions')
    <li>
        <a href="{{route('admin.allRoles')}}" class="{{ isRouteNameActive('admin.allRoles') }}">
            <span class="nav-link-icon">
                <i class="bi bi-vinyl"></i>
            </span>
            <span>Roles</span>
        </a>
    </li>

    <li>
        <a href="{{route('admin.allPermissions')}}" class="{{ isRouteNameActive('admin.allPermissions') }}">
            <span class="nav-link-icon">
                <i class="bi bi-gear-wide-connected"></i>
            </span>
            <span>Permissions</span>
        </a>
    </li>
    @endcan
    @can('view package types')
    <li>
        <a href="{{route('packageTypes.allPackageTypes')}}" class="{{ isRouteNameActive('packageTypes.allPackageTypes') }}">
            <span class="nav-link-icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span>Package Types</span>
        </a>
    </li>
    @endcan
    @can('view tax ranges')
    <li>
        <a href="{{route('admin.allTaxes')}}" class="{{ isRouteNameActive('admin.allTaxes') }}">
            <span class="nav-link-icon">
                <i class="bi bi-receipt"></i>
            </span>
            <span>Salary Taxes</span>
        </a>
    </li>
    @endcan
    @can('view holidays')
    <li>
        <a href="{{route('admin.allHolidays')}}" class="{{ isRouteNameActive('admin.allHolidays') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar3"></i>
            </span>
            <span>Holidays</span>
        </a>
    </li>
    @endcan
    @can('view leave types')
    <li>
        <a href="{{route('admin.allLeaveTypes')}}" class="{{ isRouteNameActive('admin.allLeaveTypes') }}">
            <span class="nav-link-icon">
                <i class="bi bi-calendar-event"></i>
            </span>
            <span>Leave Types</span>
        </a>
    </li>
    @endcan
    @can('view dispositions')
    <li>
        <a href="{{route('dispositions.allDispositions')}}" class="{{ isRouteNameActive('dispositions.allDispositions') }}">
            <span class="nav-link-icon">
                <i class="bi bi-command"></i>
            </span>
            <span>Dispositions</span>
        </a>
    </li>
    @endcan

</ul>