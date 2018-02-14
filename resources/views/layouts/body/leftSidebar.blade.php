<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/profile/{{Auth::user()->image}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="@if(Request::segment(1) == "designer") active @endif">
                <a href="/designer/insert">
                    <i class="fa fa-pencil"></i> <span>Insert</span>
                </a>
            </li>
            <li  class="@if(Request::segment(1) == "kasir") active @endif">
                <a href="/kasir/data">
                    <i class="fa fa-list"></i> <span>Kasir Data List</span>
                </a>
            </li>
            <li  class="@if(Request::segment(1) == "operator") active @endif">
                <a href="/operator/data">
                    <i class="fa fa-list"></i> <span>Operator Data List</span>
                </a>
            </li>
            <li  class="@if(Request::segment(1) == "profile") active @endif">
                <a href="/profile/{{Auth::user()->id}}">
                    <i class="fa fa-user"></i> <span>Profile</span>
                </a>
            </li>
            <li  class="@if(Request::segment(1) == "user") active @endif">
                <a href="/user/list">
                    <i class="fa fa-user"></i> <span>Users</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>