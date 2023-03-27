@extends('layouts.front')
@section('title')
   Welcome
@endsection
@section('css')
@endsection
@section('content')
<section class="bkLive-landing-section">
    <header class="container text-justify">
        <div class="row">
            <div class="col-12 d-flex">
                <a href="{{route('home')}}">
                    <img class="lazyload img-fluid bklive-logo"
                    src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                    data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" />
                </a>
                <ul>
                    <li>
                        <a href="https://www.facebook.com/bklivethailand">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                     <li>
                        <a href="https://www.instagram.com/bklivethailand/">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                     <li>
                        <a href=" https://www.tiktok.com/@bklive_official">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </li>
                     <li>
                        <a href="mailto:bkliveofficial@bklivethailand.com" >
                            <i class="fas fa-envelope"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <h1 class="text-center mb-5">Welcome To Bk Live</h1> -->
    </header>
    <div class="hero-bkLive-section">
        <div class="bk-live-txt"></div>
        <div class="btn-wrap">
            <a href="https://play.google.com/store/apps/details?id=com.bklive.stream" target="_blank"></a>
            <a href="https://apps.apple.com/us/app/bk-live-streaming/id1543652587"></a>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade coming-soon-modal" id="comingsoon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="./assets/images/multi-setting-img.png" class="img-fluid coming-soonintro-img" alt="">
                <!-- <h1> Coming Soon </h1> -->
                <p> This page is under constructions </p>
                <a href="index.html" class=" custom-btn  mt-4 mx-auto  ">
                    Get the App
                 </a>
            </div>
        </div>
     </div>
</div> 
@endsection

@section('js')

@endsection
