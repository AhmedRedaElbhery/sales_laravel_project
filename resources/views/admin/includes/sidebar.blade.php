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
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin.adminpanelsettings.*', 'admin.treasuries.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin.adminpanelsettings.*', 'admin.treasuries.*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.general_settings') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.adminpanelsettings.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.adminpanelsettings.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.general_settings') }}
                                        </p>
                                    </a>

                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.treasuries.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.treasuries.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.treasuries') }}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin.accounttypes.index', 'collect_transaction.*', 'exchange_transaction.*' , 'accounts.*', 'customers.*', 'suppliers_category.*', 'suppliers.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin.accounttypes.index', 'collect_transaction.*', 'exchange_transaction.*' , 'accounts.*', 'customers.*', 'suppliers_category.*', 'suppliers.*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.accounts') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.accounttypes.index') }}"
                                        class="nav-link  {{ request()->routeIs('admin.accounttypes.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.account_types') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('accounts.index') }}"
                                        class="nav-link  {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.financial_accounts') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('customers.index') }}"
                                        class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.customers') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('suppliers_category.index') }}"
                                        class="nav-link {{ request()->routeIs('suppliers_category.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.supplier_categories') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('suppliers.index') }}"
                                        class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.suppliers') }}
                                        </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ route('collect_transaction.index') }}"
                                        class="nav-link {{ request()->routeIs('collect_transaction.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.collect_transaction') }}
                                        </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ route('exchange_transaction.index') }}"
                                        class="nav-link {{ request()->routeIs('exchange_transaction.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.exchange_transaction') }}
                                        </p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li
                            class="nav-item has-treeview  {{ request()->routeIs('admin.sales_material.*', 'admin.store.*', 'unit.*', 'category.*', 'itemcard.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('admin.sales_material.*', 'admin.store.*', 'unit.*', 'category.*', 'itemcard.*') ? 'active' : '' }}">

                                <p>
                                    {{ __('sidebar.inventory_settings') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="{{ route('admin.sales_material.index') }}"
                                        class="nav-link  {{ request()->routeIs('admin.sales_material.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.sales_material_types') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.store.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.store.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.stores') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('unit.index') }}"
                                        class="nav-link {{ request()->routeIs('unit.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.units') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}"
                                        class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.categories') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('itemcard.index') }}"
                                        class="nav-link {{ request()->routeIs('itemcard.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.items') }}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin..*', 'supplier_orders.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin..*', 'supplier_orders.*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.inventory_transactions') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('supplier_orders.index') }}"
                                        class="nav-link {{ request()->routeIs('supplier_orders.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.purchase_invoices') }}
                                        </p>
                                    </a>
                                </li>


                            </ul>


                        </li>


                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin..*','sales_bills.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin..*', 'sales_bills.*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.sales') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('sales_bills.index') }}"
                                        class="nav-link {{ request()->routeIs('sales_bills.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.sales_invoices') }}
                                        </p>
                                    </a>
                                </li>


                            </ul>
                        </li>




                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin..*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin..*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.services') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>



                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin_shifts.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin_shifts.*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.treasury_shift') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin_shifts.index') }}"
                                        class="nav-link {{ request()->routeIs('admin_shifts.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.treasury_shifts') }}
                                        </p>
                                    </a>
                                </li>


                            </ul>
                        </li>




                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin_accounts.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin_accounts.*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.permissions') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>


                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin_accounts.index') }}"
                                        class="nav-link {{ request()->routeIs('admin_accounts.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ __('sidebar.users') }}
                                        </p>
                                    </a>
                                </li>


                            </ul>

                        </li>


                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin..*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin..*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.reports') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                            </ul>
                        </li>

                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin..*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link  {{ request()->routeIs('admin..*') ? 'active' : '' }} ">

                                <p>
                                    {{ __('sidebar.monitoring_support') }}
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
