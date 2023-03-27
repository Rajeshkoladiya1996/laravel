<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content= "width=device-width, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Clip board Avatar</title>
    <link rel="stylesheet" href="{{ URL::to('storage/app/public/Adminassets/css/avtar.css') }}" />
    <script src="{{URL::to('storage/app/public/Adminassets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('storage/app/public/Adminassets/js/socket.io.dev.js')}}"></script>
  </head>
  <body>
    <div class="main-wrap">
      <div class="main-content">
        <div class="main-avatar-section">
           <div class="save-avatar" id="download-avatar" data-user-id="{{$user->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13 12h3l-4 4-4-4h3V8h2v4zm2-8H5v16h14V8h-4V4zM3 2.992C3 2.444 3.447 2 3.999 2H16l5 5v13.993A1 1 0 0 1 20.007 22H3.993A1 1 0 0 1 3 21.008V2.992z"/></svg>
          </div>
          <div class="main-avatar-wrap">
          <ul class="avatar-accessory-list">
          @foreach($category->slice(0,4) as $key => $val)
            <button data-button-id="category{{ $val->id }}" class="avatar-style-btn category{{$val->id}}">
              <img src="{{ URL::to('storage/app/public/uploads/avtar/category/',$val->image) }}" alt="" />
            </button>
          @endforeach
          </ul>
          <div class="main-avatar" id="main-avatar">
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
                      @if($component->is_buy === 1 || $component->component_id == 'No')
                        <div class="{{ $val->class_name }} edit-option @if($key == 0)option-active @endif" id="{{ $component->component_id }}">
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
                      @endif
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
    <script src="https://cdn.jsdelivr.net/npm/canvg/dist/browser/canvg.min.js"></script>
    <script>
       let socket = io("https://staging.bklive.stream:7850/");
        socket.on("avtar_attribute_cart",async (data) => {
          console.log(data);
        });

        let prepareReturnData = {};

        $('.cart-btn1').on('click',function(e){
            // e.preventdefault();
            var userId = $(this).attr('data-user');
            var componentId = $(this).attr('data-component');
            var amount = $(this).attr('data-amount');
            var data = {'user_id':userId,'avatar_component_id':componentId,'amount':amount};
            socket.emit('avtar_attribute_cart',data);
        });

        $('body').on('click','#download-avatar',function(e){

          var userId = $(this).attr('data-user-id');
          var svg = document.getElementById("main-avatar").children[0];
          var svgData = new XMLSerializer().serializeToString(svg);

          var canvas = document.createElement( "canvas" );
          var ctx = canvas.getContext( "2d" );

          var img = document.createElement( "img" );
          img.setAttribute( "src", "data:image/svg+xml;base64," + btoa( svgData ) );
          img.onload = function() {
              canvas.width = 1000;
              canvas.height = 1000;
              ctx.drawImage(img, 200, 0 );
              // Now is done
              const base64Image = canvas.toDataURL("image/png");
              prepareReturnData = {
                    user_id:userId,
                    status:2, // Pending
                    message:"loading......"
              }
              socket.emit('save_avatar_image',prepareReturnData);
              var form  = new FormData();
              form.append('images',base64Image);
              form.append('id',userId);
              $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin.avtar.save')}}",
                method: 'POST',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                  let messageText = '';
                  if(data == 1){
                    messageText='You have save avatar successfully.';
                  }else{
                    messageText='Someting went wrong.';
                  }
                  prepareReturnData = {
                    user_id:userId,
                    status:data,
                    message:messageText
                  }
                  socket.emit('save_avatar_image',prepareReturnData);
                },
              });
          };
        
        })


    </script>
  </body>
</html>

