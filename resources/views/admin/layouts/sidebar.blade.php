<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
        <div class="user-profile">
            <div class="user-pro-body">
                <div><img src="{{asset('admin-asset/assets/images/users/2.jpg')}}" alt="user-img" class="img-circle"></div>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                    @if(Auth::check())
                        {{ Auth::user()->name }}
                    @endif

                    <span class="caret"></span></a>
                    <div class="dropdown-menu animated flipInY">
                        <!-- text-->
                        <a href="{{url(route('admin.users.show',[Auth::user()->id]))}}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="{{route('admin.logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                        <!-- text-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">

            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{ route('admin.home')  }}" aria-expanded="false"><i class="icon-speedometer"></i><span class="hide-menu">Dashboard</span></a></li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Users Management</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.users.index')}}">Admins</a></li>
                        <li><a href="{{route('admin.permgroups.index')}}">Permissions Groups</a></li>
                        <li><a href="{{route('admin.permissions.index')}}">Permissions</a></li>
                        <li><a href="{{route('admin.roles.index')}}">Roles</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Client Management</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.customers.index')}}">Customers</a></li>
                        <li> <a href="{{URL('big-boss/contactuser')}}" >ContactUser</a></li>
                        <li><a href="{{route('admin.subscribers.index')}}">Subscribers</a></li>
                        <li><a href="{{route('admin.reviews.index')}}">Reviews</a></li>
                        <li> <a href="{{route('admin.complaints.index')}}">Complaints</a></li>
                        <li> <a href="{{route('admin.points.index')}}">Points</a></li>

                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Catalog</span></a>
                    <ul aria-expanded="false" class="collapse">

                        <li> <a href="{{route('admin.brands.index')}}">Brands</a></li>
                        <li> <a href="{{route('admin.manufacturers.index')}}">Manufacturers</a></li>
                        <li><a href="{{route('admin.categories.index')}}">Categories</a></li>
                        <li><a href="{{route('admin.products.index')}}">Products</a></li>
                        <li><a href="{{route('admin.products.onsale')}}">On Sale Products</a></li>
                        <li><a href="{{route('admin.products.hot')}}">Hot Products</a></li>
                        <li><a href="{{route('admin.products.combo')}}">Combo Products</a></li>
                        <li><a href="{{route('admin.bundles.index')}}">Bundles</a></li>
                        <li><a href="{{route('admin.combo.index')}}">Combo</a></li>
                        <li><a href="{{route('admin.attrgroups.index')}}">Attribute Groups</a></li>
                        <li><a href="{{route('admin.attributes.index')}}">Attributes</a></li>
                        <li><a href="{{url('big-boss/bulk_image_upload')}}">Bulk Image Upload</a></li>
                        <li> <a href="{{route('admin.dealsection.index')}}">Deal Sections</a></li>

                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Orders</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('admin.orders.index')}}">Orders</a></li>
                        <li> <a href="{{route('admin.orders.cancelled')}}">Cancelled Orders</a></li>
                        <li> <a href="{{route('admin.transactions.index')}}">Transactions</a></li>
                        <li> <a href="{{route('admin.shipping_requests.index')}}">Shipping Requests</a></li>
                        <li> <a href="{{route('admin.withdraws.index')}}">Withdraws</a></li>
                        <!-- <li> <a href="{{route('admin.returns.index')}}">Return Orders</a></li>
                        <li> <a href="{{route('admin.return_reasons.index')}}">Return Reasons</a></li> -->
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Shipping Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('admin.shipping_companies.index')}}">Companies</a></li>
                        <li> <a href="{{route('admin.shipping_zones.index')}}">Zones</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Marketing</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.cupons.index')}}">Coupons</a></li>
                        <li><a href="{{route('admin.promotions.index')}}">Promotions</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Destination</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.countries.index')}}">Countries</a></li>
                        <li><a href="{{route('admin.cities.index')}}">Cities</a></li>
                        <li><a href="{{route('admin.states.index')}}">Area</a></li>
                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.modules.index')}}" aria-expanded="false"><i class="ti-layout-accordion-merged"></i><span class="hide-menu">Modules</span></a></li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.translations.index')}}">Translations</a></li>
                        <li><a href="{{route('admin.setting.main_setting')}}">Main Setting</a></li>
                        <li><a href="{{route('admin.priroty')}}">Offer Setting</a></li>
                        <li><a href="{{route('admin.setting.index')}}">Setting</a></li>
                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('admin.page.index')  }}" aria-expanded="false"><i class="ti-layout-accordion-merged"></i><span class="hide-menu">Pages</span></a></li>
                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Inventories</span></a>
                    <ul aria-expanded="false" class="collapse">
                <li> <a href="{{route('admin.inventories.index')}}">Inventories</a></li>
                        <li><a href="{{route('admin.locations.index')}}">Locations</a></li>
                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.logs')}}" aria-expanded="false"><i class="ti-layout-accordion-merged"></i><span class="hide-menu">Dashboard Logs</span></a></li>

{{--                <li> <a class="waves-effect waves-dark" href="{{route('admin.packages.index')}}" aria-expanded="false"><i class="ti-layout-accordion-merged"></i><span class="hide-menu">Packages</span></a></li>--}}

                <!--------------------------contactuser------------------->

                         </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
