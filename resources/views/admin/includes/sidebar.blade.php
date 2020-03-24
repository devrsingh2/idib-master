<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="{{ url('/') }}/admin" class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" height="60" alt="logo">
        </a>
    </div>
    <div class="mdc-drawer__content">
        <div class="user-info">
            <p class="name">{{ auth()->user()->name }}</p>
            <p class="email">{{ auth()->user()->email }}</p>
        </div>
        <div class="mdc-list-group">
            <nav class="mdc-list mdc-drawer-menu">
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="{{ route('admin.dashboard') }}">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>
                        Dashboard
                    </a>
                </div>
                {{--<div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="{{ route('admin.products') }}">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">pages</i>
                        Products
                    </a>
                </div>--}}
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="{{ route('admin.orders') }}">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">track_changes</i>
                        Orders
                    </a>
                </div>
                {{--<div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel" data-target="ui-sub-menu">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>
                        Manage Categories
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel" id="ui-sub-menu">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="{{ route('admin.categories') }}">
                                    Categories
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>--}}
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link @if(
                    request()->segment(3) === 'jackets' ||
                    request()->segment(3) === 'pants' ||
                    request()->segment(3) === 'vests'
                    ) expanded @endif" href="#" data-toggle="expansionPanel" data-target="ui-sub-menu">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>
                        Suit
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel" id="ui-sub-menu" @if(
                    request()->segment(3) === 'jackets' ||
                    request()->segment(3) === 'pants' ||
                    request()->segment(3) === 'vests'
                    ) style="display: block;" @endif>
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="{{ route('admin.suits.categories') }}">
                                    Categories
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link @if(request()->segment(3) === 'jackets') active @endif" href="{{ route('admin.suits.jackets') }}">
                                    Jackets
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link @if(request()->segment(3) === 'pants') active @endif" href="{{ route('admin.suits.pants') }}">
                                    Pant
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link @if(request()->segment(3) === 'vests') active @endif" href="{{ route('admin.suits.vests') }}">
                                    Vest
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="{{ route('admin.suits.fabrics') }}">
                                    Fabrics
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="{{ route('admin.suits.accents') }}">
                                    Accent
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
            </nav>
        </div>
        <div class="profile-actions">
            <a href="javascript:;">Settings</a>
            <span class="divider"></span>
            <a href="{{ route('user.logout') }}">Logout</a>
        </div>

    </div>
</aside>