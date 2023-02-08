<ul>
<li class="menu-divider">Main</li>
            <li>
                <a  class="active"
                    href="{{route('adminDashboard')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-house-door"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
                <a 
                    href="{{route('users.allUsers')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-person"></i>
                    </span>
                    <span>Users</span>
                </a>
                <a href="{{route('attendance.userAttendance',['id'=>auth()->user()->id,'month'=>date('m'),'year'=>date('Y')])}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-clock"></i>
                    </span>
                    <span>Attendance</span>
                </a>
                <a href="{{route('leaves.showLeaves')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-calendar-plus"></i>
                    </span>
                    <span>Leave Request</span>
                </a>
            </li>
            
            <li class="menu-divider">Sales Force</li>
            @can('view leads')
            <li>
                
                <a  
                    href="{{route('lead.allLeads')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-telephone-inbound"></i>
                    </span>
                    <span>Leads</span>
                </a>
            </li>
            @endcan
            <li>
                <a  
                    href="{{route('opportunity.allOpportunities')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-briefcase"></i>
                    </span>
                    <span>Opportunities</span>
                </a>
            </li>
            
            <li class="menu-divider">Marketing</li>
            <li>
                <a  
                    href="{{route('brands.allBrands')}}">
                    <span class="nav-link-icon">
                    <i class="bi bi-building"></i>
                    </span>
                    <span>Brands</span>
                </a>
            </li>
            <li>
                <a  
                    href="{{route('packages.allPackages')}}">
                    <span class="nav-link-icon">
                    <i class="bi bi-box"></i>
                    </span>
                    <span>Packages</span>
                </a>
            </li>
            <li class="menu-divider">Collateral</li>
            @can('view projects')
            <li>
                
                <a  
                    href="{{route('projects.allProjects')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-kanban-fill"></i>
                    </span>
                    <span>Projects</span>
                </a>
            </li>
            @endcan
            @role('admin')
            <li class="menu-divider">Settings</li>
            <li>
                <a  
                    href="{{route('admin.allTeams')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-people"></i>
                    </span>
                    <span>Teams</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.allRoles')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-vinyl"></i>
                    </span>
                    <span>Roles</span>
                </a>
            </li>
            
            <li>
                <a  
                    href="{{route('admin.allPermissions')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-gear-wide-connected"></i>
                    </span>
                    <span>Permissions</span>
                </a>
            </li>
            <li>
                <a  
                    href="{{route('packageTypes.allPackageTypes')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-box-seam"></i>
                    </span>
                    <span>Package Types</span>
                </a>
            </li>
            <li>
                <a  
                    href="{{route('admin.allHolidays')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <span>Holidays</span>
                </a>
            </li>
            <li>
                <a  
                    href="{{route('admin.allLeaveTypes')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-calendar-event"></i>
                    </span>
                    <span>Leave Types</span>
                </a>
            </li>
            @endrole
            
        </ul>