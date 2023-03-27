<header>
    <nav class="navbar navbar-expand-lg">
        <div class="logo-bg">
            <a class="navbar-brand" href="javascript:void(0)"><img class="lazyload img-fluid"
                    src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                    data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" /></a>

            <a class="navbar-brand2" href="javascript:void(0)"><img class="lazyload img-fluid"
                    src="{{ URL::to('storage/app/public/Adminassets/image/logo-3.svg') }}"
                    data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-3.svg') }}" alt="logo" /></a>
        </div>
        <button class="button is-text" id="menu-button" onclick="buttonToggle()">
            <div class="button-inner-wrapper">
                <span class="icon menu-icon"></span>
            </div>
        </button>
        <ul class="header-ul">
            @if (Auth::user()->hasRole('super-admin'))
                <li class="d-flex align-items-center">
                    <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" data-toggle="modal"
                        data-target="#subadmin-add"> + Add Sub admin</a>
                </li>
            @endif
            <li class="dropdown">
                <a href="javascript:void(0)" class="header-notification dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg id="notification-line" xmlns="http://www.w3.org/2000/svg" width="20.205" height="20.205"
                        viewBox="0 0 20.205 20.205">
                        <path id="Path_369" data-name="Path 369" d="M0,0H20.2V20.2H0Z" fill="none" />
                        <path id="Path_370" data-name="Path 370"
                            d="M4.684,15.47H16.47V9.6a5.893,5.893,0,1,0-11.786,0ZM10.577,2a7.59,7.59,0,0,1,7.577,7.6v7.551H3V9.6A7.59,7.59,0,0,1,10.577,2Zm-2.1,16h4.209a2.1,2.1,0,1,1-4.209,0Z"
                            transform="translate(-0.474 -0.316)" />
                    </svg>
                </a>
                <div class="dropdown-menu dropdown-menu2" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="Javascript:void(0)">Lorem Ipsum is simply dummy text of the printing
                        and
                        typesetting industry. </a>
                    <a class="dropdown-item" href="Javascript:void(0)">Lorem Ipsum is simply dummy text of the printing
                        and
                        typesetting industry. </a>
                    <a class="dropdown-item" href="Javascript:void(0)">Lorem Ipsum is simply dummy text of the printing
                        and
                        typesetting industry. </a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="header-profile dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::user())
                        <img src="{{ URL::to('storage/app/public/uploads/users/' . Auth::user()->profile_pic) }}" alt="">
                    @else
                        <img src="{{ URL::to('storage/app/public/Adminassets/image/profile.jpg') }}" alt="">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu2 dropdown-profile" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fal fa-sign-out"></i>
                        Logout</a>
                </div>
            </li>
        </ul>
    </nav>
</header>
