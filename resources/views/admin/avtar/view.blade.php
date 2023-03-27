<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content= "width=device-width, user-scalable=no">
    <title>New Avatar</title>
    <link rel="stylesheet" href="{{ URL::to('storage/app/public/Adminassets/css/avtar.css') }}" />
    <script src="{{URL::to('storage/app/public/Adminassets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('storage/app/public/Adminassets/js/socket.io.dev.js')}}"></script>
  </head>
  <body>
    <div class="main-wrap">
      <div class="main-content">
        <div class="main-avatar-section">
        <div class="main-avatar-wrap">
          <ul class="avatar-accessory-list">
          @foreach($category->slice(0,4) as $key => $val)
            <button data-button-id="category{{ $val->id }}" class="avatar-style-btn category{{$val->id}}">
              <img src="{{ URL::to('storage/app/public/uploads/avtar/category/',$val->image) }}" alt="" />
            </button>
          @endforeach
          </ul>
          <div class="main-avatar">
            {!! file_get_contents('storage/app/public/uploads/avtar/'.$svg->image) !!}
          </div>
          <ul class="avatar-accessory-list">
            @foreach($category->slice(4, 7) as $key => $val)
              <button data-button-id="category{{ $val->id }}" class="avatar-style-btn category{{$val->id}}">
                <img src="{{ URL::to('storage/app/public/uploads/avtar/category/',$val->image) }}" alt="" />
              </button>
            @endforeach
          </ul>
        </div>
        </div>
        <div class="avatar-editor">
          <div class="avatar-edit-categories">
            @foreach($category as $key => $val)
              <button data-button-id="category{{ $val->id }}" class="category-btn @if($key == 0)category-active @endif">
                <img src="{{ URL::to('storage/app/public/uploads/avtar/category/',$val->image) }}" alt="shirt" />
              </button>
            @endforeach
          </div>
          <div class="avatar-edit-panels">
          
           @foreach($category as $key => $val)
              <div id="category{{ $val->id }}" class="edit-panel @if($key == 0)panel-active @endif">
                <div class="edit-panel-inner">
                  @if(isset($val->avtarcomponent))
                  @foreach($val->avtarcomponent as $key => $component)
                  <div class="{{ $val->class_name }} edit-option @if($key == 0)option-active @endif" id="{{ $component->component_id }}">
                    @if($component->amount != 0) 
                  
                    <a href="javascript:void(0)" class="cart-btn cart-btn1 @if($component->is_cart == 1) selected @endif" data-user="{{ ($user) ? $user->id : '' }}" data-avtar="{{ $component->avtartype_id }} " data-component ="{{ $component->id }}" data-amount="{{$component->amount}}">
                      <svg  width="512" height="512" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg" >
                      <path  fill-rule="evenodd" clip-rule="evenodd" d="M7.761 48.023C3.539 50.2499 0 56.1441 0 60.9484C0 65.9056 3.537 71.6609 7.974 73.9227C11.699 75.8209 13.818 75.9338 45.77 75.9338H79.619L115.47 205.058C135.188 276.075 152.155 335.861 153.174 337.915C154.349 340.283 156.47 342.382 158.974 343.659C162.873 345.646 164.586 345.67 301 345.67C437.916 345.67 439.113 345.653 443.07 343.636C445.85 342.22 447.66 340.325 449.037 337.392C451.75 331.614 512.004 123.722 511.984 120.212C511.959 116.064 508 109.875 504.016 107.757C500.658 105.971 493.61 105.904 309.833 105.904C129.086 105.904 119.107 105.814 118.601 104.156C118.307 103.194 115.19 92.056 111.674 79.4034C108.159 66.7507 104.534 54.9543 103.62 53.189C102.692 51.3947 100.221 49.093 98.019 47.9711C94.257 46.0529 92.221 45.965 52.79 46.007C13.658 46.049 11.305 46.1549 7.761 48.023ZM476.557 137.694C475.094 142.299 425 314.777 425 315.21C425 315.48 369.286 315.7 301.19 315.7H177.38L153.007 228.035C139.602 179.819 128.439 139.36 128.2 138.123L127.767 135.875H302.451C470.965 135.875 477.114 135.939 476.557 137.694ZM188.761 197.877C184.539 200.103 181 205.998 181 210.802C181 215.759 184.537 221.515 188.974 223.776C192.857 225.755 194.653 225.787 301 225.787C407.347 225.787 409.143 225.755 413.026 223.776C417.463 221.515 421 215.759 421 210.802C421 205.845 417.463 200.089 413.026 197.828C409.141 195.848 407.392 195.818 300.79 195.861C194.949 195.904 192.415 195.95 188.761 197.877ZM218.761 257.818C214.539 260.045 211 265.939 211 270.743C211 275.701 214.537 281.456 218.974 283.718C222.829 285.683 224.72 285.729 301 285.729C377.28 285.729 379.171 285.683 383.026 283.718C387.463 281.456 391 275.701 391 270.743C391 265.786 387.463 260.031 383.026 257.769C379.168 255.803 377.326 255.759 300.79 255.802C224.818 255.845 222.389 255.905 218.761 257.818ZM200.5 377.061C192.08 379.166 185.777 382.76 179.428 389.079C161.683 406.74 161.695 434.368 179.456 452.11C205.296 477.925 248.98 463.864 255.182 427.735C257.613 413.572 253.047 399.597 242.544 389.056C231.267 377.738 215.634 373.278 200.5 377.061ZM380.5 377.061C372.08 379.166 365.777 382.76 359.428 389.079C341.683 406.74 341.695 434.368 359.456 452.11C385.296 477.925 428.98 463.864 435.182 427.735C437.613 413.572 433.047 399.597 422.544 389.056C411.267 377.738 395.634 373.278 380.5 377.061ZM218.026 407.623C222.463 409.885 226 415.64 226 420.597C226 428.233 218.607 435.582 210.926 435.582C206.275 435.582 200.097 431.697 197.897 427.388C194.204 420.156 196.522 412.261 203.593 407.984C208.381 405.089 212.835 404.977 218.026 407.623ZM398.026 407.623C402.463 409.885 406 415.64 406 420.597C406 428.233 398.607 435.582 390.926 435.582C386.275 435.582 380.097 431.697 377.897 427.388C374.204 420.156 376.522 412.261 383.593 407.984C388.381 405.089 392.835 404.977 398.026 407.623Z" fill="#fff"/>
                      </svg>
                    </a>
               
                    @endif
                   
                    <div>
                      <div class="option-content">
                        <img src="{{ URL::to('storage/app/public/uploads/avtar/component/',$component->image) }}" alt="{{ $val->name }}" />
                      </div>

                      <div class="salmon-number">
                        <div class="salmon-img">
                          <img src="{{ URL::to('storage/app/public/uploads/avtar/salmon-coin.png') }}" alt="coin" />
                        </div>
                        <div class="salmon-count">{{ $component->amount }}</div>
                      </div>
                    </div>

                  </div>
                  @endforeach
                  @endif
                </div>
              </div>
            @endforeach
            
          </div>
        </div>
      </div>
    </div>
    <script src="{{ URL::to('storage/app/public/Adminassets/js/avtar.js') }}"></script>
    <script>
       let socket = io("https://staging.bklive.stream:7850/");
        socket.on("avtar_attribute_cart",async (data) => {
          console.log(data);
        });

        $('.cart-btn1').on('click',function(e){
            // e.preventdefault();
            var userId = $(this).attr('data-user');
            var componentId = $(this).attr('data-component');
            var amount = $(this).attr('data-amount');
            var data = {'user_id':userId,'avatar_component_id':componentId,'amount':amount};
            socket.emit('avtar_attribute_cart',data);
        });

    </script>
  </body>
</html>

