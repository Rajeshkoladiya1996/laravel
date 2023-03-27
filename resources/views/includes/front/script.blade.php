<!-- bootstrap js -->
<script src="{{URL::to('storage/app/public/Adminassets/js/jquery.min.js')}}"></script>

<script src="{{URL::to('storage/app/public/Adminassets/js/bootstrap.bundle.min.js')}}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<!-- img-lazyload js -->
<script type="text/javascript" src="{{URL::to('storage/app/public/Adminassets/js/lottie.js')}}"></script>

<script type="text/javascript">
	let base_url="{{URL::to('/godmode')}}";
</script>
@yield('js')

<script type="text/javascript">
    var amination = bodymovin.loadAnimation({
        container:document.getElementById('spinner'),
        renderer:'svg',
        loop: true,
        autoplay: true,
        path:"{{URL::to('storage/app/public/Adminassets/gif/data.json')}}"
    })
</script>