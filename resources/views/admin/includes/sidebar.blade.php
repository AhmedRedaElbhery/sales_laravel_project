        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview {{ request()->routeIs('admin.adminpanelsettings.*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin.adminpanelsettings.*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    الضبط العام
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.adminpanelsettings.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.adminpanelsettings.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            الضبط العام
                                        </p>
                                    </a>

                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.treasuries.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.treasuries.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            بيانات الخزن
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item has-treeview {{ request()->routeIs('admin.accounttypes.index' , 'accounts.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin.accounttypes.index' , 'accounts.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     الحسابات
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.accounttypes.index') }}" class="nav-link  {{ request()->routeIs('admin.accounttypes.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            انواع الحسابات الماليه
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('accounts.index') }}" class="nav-link  {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                         الحسابات الماليه
                                        </p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item has-treeview  {{ request()->routeIs('admin.sales_material.*', 'admin.store.*', 'unit.*', 'category.*', 'itemcard.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.sales_material.*', 'admin.store.*', 'unit.*', 'category.*', 'itemcard.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    ضبط الخزن
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="{{ route('admin.sales_material.index') }}" class="nav-link  {{ request()->routeIs('admin.sales_material.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            بيانات فئات الفواتير
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.store.index') }}" class="nav-link {{ request()->routeIs('admin.store.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            بيانات المخازن
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('unit.index') }}" class="nav-link {{ request()->routeIs('unit.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            بيانات الوحدات
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            فئات الاصناف
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('itemcard.index') }}" class="nav-link {{ request()->routeIs('itemcard.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            الاصناف
                                        </p>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     حركات مخزنيه
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>


                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     المبيعات
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>




                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     خدمات داخليه وخارجيه
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>



                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                   حركه شفت الخزينه
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>




                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     الصلاحيات
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>


                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     التقارير
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>

                        <li class="nav-item has-treeview {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  {{ request()->routeIs('admin..*', 'admin.treasuries.*') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                     المراقبه والدعم الفنى
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
