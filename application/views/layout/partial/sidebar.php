<div class="menu">
    <div class="menu-header">
        <a href="./dashboard.html" class="menu-header-logo">
            <img src="<?=base_url('assets')?>/logo.svg" alt="logo">
            <span>FMS UNEJ</span>
        </a>
        <a href="#" class="btn btn-sm menu-close-btn">
            <i class="bi bi-x"></i>
        </a>
    </div>
    <div class="menu-body">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                <div class="avatar me-3">
                    <img src="https://avatar.iran.liara.run/public" class="rounded-circle" alt="image">
                </div>
                <div>
                    <div class="fw-bold"><?=$this->session->userdata('name')?></div>
                    <small class="text-muted fw-bold"><?=$this->session->userdata('username')?></small><br>
                    <small class="text-muted"><?=$this->session->userdata('role')?></small>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <small href="#" class="dropdown-item d-flex align-items-center text-xs">
                    <i class="bi bi-map dropdown-item-icon"></i> <?=$this->session->userdata('office')?>
                </small>
                <a href="#" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-envelope dropdown-item-icon"></i> Inbox
                </a>
                <a href="#" class="dropdown-item d-flex align-items-center" data-sidebar-target="#settings">
                    <i class="bi bi-gear dropdown-item-icon"></i> Settings
                </a>
                <a href="<?=base_url('auth/logout')?>" class="dropdown-item d-flex align-items-center text-danger"
                    target="_blank">
                    <i class="bi bi-box-arrow-right dropdown-item-icon"></i> Logout
                </a>
            </div>
        </div>
        <ul>
            <li class="menu-divider">Dashboard</li>
            <li>
                <a class="active" href="./dashboard.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-bar-chart"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-divider">Apps</li>
            <li>
                <a href="./chats.html">
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
                    <span>Email App</span>
                </a>
                <ul>
                    <li>
                        <a href="./email.html">
                            <span>Inbox</span>
                        </a>
                    </li>
                    <li>
                        <a href="./email.html-detail">
                            <span>Detail</span>
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
                        <a href="./todo-list.html">
                            <span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="./todo-detail.html">
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
                        <a href="./profile-posts.html">Post</a>
                    </li>
                    <li>
                        <a href="./profile-connections.html">Connections</a>
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
                    <li>
                        <a href="./user-list.html">List View</a>
                    </li>
                    <li>
                        <a href="./user-grid.html">Grid View</a>
                    </li>
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
                        <a href="./login.html" target="_blank">Login</a>
                    </li>
                    <li>
                        <a href="./register.html" target="_blank">Register</a>
                    </li>
                    <li>
                        <a href="./reset-password.html" target="_blank">Reset Password</a>
                    </li>
                    <li>
                        <a href="./lock-screen.html" target="_blank">Lock Screen</a>
                    </li>
                    <li>
                        <a href="./account-verified.html" target="_blank">Account Verified</a>
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
                        <a href="./404.html" target="_blank">404</a>
                    </li>
                    <li>
                        <a href="./access-denied.html">Access Denied</a>
                    </li>
                    <li>
                        <a href="./under-construction.html" target="_blank">Under Construction</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./settings.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-gear"></i>
                    </span>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="./pricing-table.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-wallet2"></i>
                    </span>
                    <span>Pricing Table</span>
                    <span class="badge bg-success ms-auto">New</span>
                </a>
            </li>
            <li>
                <a href="./search-page.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <span>Search Page</span>
                </a>
            </li>
            <li>
                <a href="./faq.html">
                    <span class="nav-link-icon">
                        <i class="bi bi-question-circle"></i>
                    </span>
                    <span>FAQ</span>
                </a>
            </li>

        </ul>
    </div>
</div>