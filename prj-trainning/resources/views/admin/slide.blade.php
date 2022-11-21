
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <p class="brand-text font-weight-light text-center">Trang quản trị</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            </div>
            <div class="info">
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 bg-info" style="border-radius: 9px;">
            <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('admin.profile')}}" class="nav-link">
                        <p>
                            Profile
                        </p>
                    </a>

                </li>

                @if($user->role == 3)
                    <li class="nav-item">
                        <a href="{{ route('admin.user.list') }}" class="nav-link">
                            <p>
                                Admin
                            </p>
                        </a>

                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('admin.user.listForUser')}}" class="nav-link">
                        <p>
                            Users
                        </p>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{route('admin.categories.list')}}" class="nav-link">
                        <p>
                            Categories
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.post.list')}}" class="nav-link">
                        <p>
                            Posts
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <p>
                            Comments
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
