<div class="main-navbar sticky-top bg-white">
    <!-- Main Navbar -->
    <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
        <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
            <input class="navbar-search form-control" type="hidden" placeholder="Search for something..." aria-label="Search">
        </form>
        <ul class="navbar-nav border-left flex-row ">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="margin-right:5px;margin-top:10px;">
                    <span class="d-none d-md-inline-block" style="margin-left:20px;margin-right:20px;"><h4>{{ Auth::user()->real_name }}</h4></span>
                </a>
                <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="user-profile-lite.html">
                        <i class="material-icons">&#xE7FD;</i> 정보변경
                    </a>
                    <!--
                    <a class="dropdown-item" href="components-blog-posts.html">
                        <i class="material-icons">vertical_split</i> Blog Posts</a>
                    <a class="dropdown-item" href="add-new-post.html">
                        <i class="material-icons">note_add</i> Add New Post</a>
                    -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url("/admin/user/logout") }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="material-icons text-danger">&#xE879;</i> {{ __('로그아웃') }}
                    </a>
                    <form id="logout-form" action="{{ url("/admin/user/logout") }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <nav class="nav">
            <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                <i class="material-icons">&#xE5D2;</i>
            </a>
        </nav>
    </nav>
</div>