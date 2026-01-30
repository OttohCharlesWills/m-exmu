 <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h4>Seller Dashboard</h4>
                {{-- <button id="closeSidebar" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-x-lg"></i>
                </button> --}}
            </div>

            <ul class="sidebar-links">
                <li>
                    <a href="{{ url('/home') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="javascript:void(0)" class="sidebar-link" id="blogToggle">
                        <i class="bi bi-pencil-square"></i>
                        <span>Products</span>
                        <i class="bi bi-chevron-down ms-auto arrow"></i>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{route('seller.products.create')}}">
                                <i class="bi bi-plus-circle"></i>
                                <span>Create product</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('seller.products.index')}}">
                                <i class="bi bi-journals"></i>
                                <span>View Products</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('seller.products.pending')}}">
                                <i class="bi bi-journals"></i>
                                <span>Pending Products</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('wallet.index')}}">
                        <i class="bi bi-tags"></i>
                        <span>Wallet</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seller.settings.settings') }}">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Chats</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Orders</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>