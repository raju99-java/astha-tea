        <div class="col-lg-4">
          <div class="user-profile-info-area">
            <ul class="links">
                @php

                  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                  {
                    $link = "https";
                  }
                  else
                  {
                    $link = "http";

                    // Here append the common URL characters.
                    $link .= "://";

                    // Append the host(domain name, ip) to the URL.
                    $link .= $_SERVER['HTTP_HOST'];

                    // Append the requested resource location to the URL
                    $link .= $_SERVER['REQUEST_URI'];
                  }

                @endphp
              <li class="{{ $link == route('user-dashboard') ? 'active':'' }}">
                <a href="{{ route('user-dashboard') }}">
                  {{ __('Dashboard') }}
                </a>
              </li>

              

              <li class="{{ $link == route('user-orders') ? 'active':'' }}">
                <a href="{{ route('user-orders') }}">
                  {{ __('Purchased Items') }}
                </a>
              </li>

              <li class="{{ $link == route('user-customtea-orders') ? 'active':'' }}">
                <a href="{{ route('user-customtea-orders') }}">
                  {{ __('Custom Tea Purchased Items') }}
                </a>
              </li>

              <li class="{{ $link == route('user-customtea') ? 'active':'' }}">
                <a href="{{ route('user-customtea') }}">
                  {{ __('Custom Tea Composition') }}
                </a>
              </li>    



              <!-- <li class="{{ $link == route('user-order-track') ? 'active':'' }}">
                  <a href="{{route('user-order-track')}}">{{ __('Order Tracking') }}</a>
              </li>


              <li class="{{ $link == route('user-messages') ? 'active':'' }}">
                  <a href="{{route('user-messages')}}">{{ __('Messages') }}</a>
              </li> -->


              <li class="{{ $link == route('user-profile') ? 'active':'' }}">
                <a href="{{ route('user-profile') }}">
                  {{ __('Edit Profile') }}
                </a>
              </li>

              <!-- <li class="{{ $link == route('user-reset') ? 'active':'' }}">
                <a href="{{ route('user-reset') }}">
                 {{ __('Reset Password') }}
                </a>
              </li> -->

              <li>
                <a href="{{ route('user-logout') }}">
                  {{ __('Logout') }}
                </a>
              </li>

            </ul>
          </div>
          
        </div>
