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
                        <i class="bi bi-person"></i>
                    </span>
                    <span>Attendance</span>
                </a>
            </li>
            <!-- <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <span>Orders</span>
                </a>
                <ul>
                    <li>
                        <a  href="./orders.html">List</a>
                    </li>
                    <li>
                        <a  href="./order-detail.html">Detail</a>
                    </li>
                </ul>
            </li> -->
            
            
            <!-- <li>
                <a  href="./customers.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-person-badge"></i>
                    </span>
                    <span>Customers</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <span>Invoices</span>
                </a>
                <ul>
                    <li>
                        <a href="./invoices.html"
                           >List</a>
                    </li>
                    <li>
                        <a href="./invoice-detail.html"
                           >Detail</a>
                    </li>
                </ul>
            </li> -->
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
                <a  
                    href="{{route('admin.allRoles')}}">
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
            @endrole
            <!-- <li class="menu-divider">Apps</li>
            <li>
                <a  href="./chats.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-chat-square"></i>
                    </span>
                    <span>Chats</span>
                    <span class="badge bg-success rounded-circle ms-auto">2</span>
                </a>
            </li>
            <li>
                <a href="./email.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <span>Email</span>
                </a>
                <ul>
                    <li>
                        <a  href="./email.html">
                            <span>Inbox</span>
                        </a>
                    </li>
                    <li>
                        <a  href="./email-detail.html">
                            <span>Detail</span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="./email-template.html">
                            <span>Email Template</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./todo-list.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-check-circle"></i>
                    </span>
                    <span>Todo App</span>
                </a>
                <ul>
                    <li>
                        <a  href="./todo-list.html">
                            <span>List</span>
                        </a>
                    </li>
                    <li>
                        <a  href="./todo-detail.html">
                            <span>Details</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-divider">Pages</li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-person"></i>
                    </span>
                    <span>Profile</span>
                </a>
                <ul>
                    <li>
                        <a  href="#">Post</a>
                    </li>
                    <li>
                        <a  href="#">Connections</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <span>Users</span>
                </a>
                <ul>
                    <li><a  href="#">List View</a></li>
                    <li><a  href="#">Grid View</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-lock"></i>
                    </span>
                    <span>Authentication</span>
                </a>
                <ul>
                    <li>
                        <a href="#" target="_blank">Login</a>
                    </li>
                    <li>
                        <a href="#" target="_blank">Register</a>
                    </li>
                    <li>
                        <a href="#" target="_blank">Reset Password</a>
                    </li>
                    <li>
                        <a href="#" target="_blank">Lock Screen</a>
                    </li>
                    <li>
                        <a href="#" target="_blank">Account Verified</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-exclamation-octagon"></i>
                    </span>
                    <span>Error Pages</span>
                </a>
                <ul>
                    <li>
                        <a href="#" target="_blank">404</a>
                    </li>
                    <li>
                        <a  href="#">Access Denied</a>
                    </li>
                    <li>
                        <a href="#" target="_blank">Under Construction</a>
                    </li>
                </ul>
            </li>
            <li>
                <a  href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-gear"></i>
                    </span>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a  href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-wallet2"></i>
                    </span>
                    <span>Pricing Table</span>
                    <span class="badge bg-success ms-auto">New</span>
                </a>
            </li>
            <li>
                <a  href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <span>Search Page</span>
                </a>
            </li>
            <li>
                <a  href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-question-circle"></i>
                    </span>
                    <span>FAQ</span>
                </a>
            </li>
            <li class="menu-divider">User Interface</li>
            <li>
                <a href="#" target="_blank">
                    <span class="nav-link-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </span>
                    <span>Components</span>
                </a>
                <ul>
                    <li>
                        <a  href="#">Accordion</a>
                    </li>
                    <li>
                        <a  href="#">Alerts</a>
                    </li>
                    <li>
                        <a  href="#">Badge</a>
                    </li>
                    <li>
                        <a  href="#">Breadcrumb</a>
                    </li>
                    <li>
                        <a  href="#">Buttons</a>
                    </li>
                    <li>
                        <a  href="#">Button Group</a>
                    </li>
                    <li>
                        <a  href="#">Card</a>
                    </li>
                    <li>
                        <a  href="#">Card Masonry</a>
                    </li>
                    <li>
                        <a  href="#">Carousel</a>
                    </li>
                    <li>
                        <a  href="#">Collapse</a>
                    </li>
                    <li>
                        <a  href="#">Dropdowns</a>
                    </li>
                    <li>
                        <a  href="#">List Group</a>
                    </li>
                    <li>
                        <a  href="#">Modal</a>
                    </li>
                    <li>
                        <a  href="#">Navs and Tabs</a>
                    </li>
                    <li>
                        <a  href="#">Pagination</a>
                    </li>
                    <li>
                        <a  href="#">Popovers</a>
                    </li>
                    <li>
                        <a  href="#">Progress</a>
                    </li>
                    <li>
                        <a  href="#">Spinners</a>
                    </li>
                    <li>
                        <a  href="#">Toasts</a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Tables</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">Tooltip</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" target="_blank">
                    <span class="nav-link-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </span>
                    <span>Forms</span>
                </a>
                <ul>
                    <li>
                        <a href="#">
                            <span>Form Elements</span>
                        </a>
                        <ul>
                            <li>
                                <a  href="#">Overview</a>
                            </li>
                            <li>
                                <a  href="#">Form Controls</a>
                            </li>
                            <li>
                                <a  href="#">Select</a>
                            </li>
                            <li>
                                <a  href="#">Checks and Radios</a>
                            </li>
                            <li>
                                <a  href="#">Range</a>
                            </li>
                            <li>
                                <a  href="#">Input Group</a>
                            </li>
                            <li>
                                <a  href="#">Floating Label</a>
                            </li>
                            <li>
                                <a  href="#">Form Layout</a>
                            </li>
                            <li>
                                <a  href="#">Validation</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Wizard</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Repeater</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>File Upload</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>CKEditor</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Range Slider</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Select2</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Tags Input</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Input Mask</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Datepicker</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Clock Picker</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-heart"></i>
                    </span>
                    <span>Content</span>
                </a>
                <ul>
                    <li>
                        <a  href="#">
                            <span>Typography</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Images</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Figures</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Avatar</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Icons</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Colors</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-bar-chart"></i>
                    </span>
                    <span>Charts</span>
                </a>
                <ul>
                    <li>
                        <a  href="#">Apex Chart</a>
                    </li>
                    <li>
                        <a  href="#">Chartjs</a>
                    </li>
                    <li>
                        <a  href="#">Justgage</a>
                    </li>
                    <li>
                        <a  href="#">Morsis</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-paperclip"></i>
                    </span>
                    <span>Extensions</span>
                </a>
                <ul>
                    <li>
                        <a  href="#">
                            <span>Vector Map</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">
                            <span>Datatable</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#">Sweet Alert</a>
                    </li>
                    <li>
                        <a  href="#">Lightbox</a>
                    </li>
                    <li>
                        <a  href="#">Introjs</a>
                    </li>
                    <li>
                        <a  href="#">Nestable</a>
                    </li>
                    <li>
                        <a  href="#">Rating</a>
                    </li>
                    <li>
                        <a  href="#">Code Highlighter</a>
                    </li>
                </ul>
            </li>
            <li class="menu-divider">Other</li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-list"></i>
                    </span>
                    <span>Menu Item</span>
                </a>
                <ul>
                    <li><a href="#">Menu Item 1</a></li>
                    <li>
                        <a href="#">Menu Item 2</a>
                        <ul>
                            <li>
                                <a href="#">Menu Item 2.1</a>
                            </li>
                            <li>
                                <a href="#">Menu Item 2.2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="disabled">
                    <span class="nav-link-icon">
                        <i class="bi bi-hand-index-thumb"></i>
                    </span>
                    <span>Disabled</span>
                </a>
            </li> -->
        </ul>