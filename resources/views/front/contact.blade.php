@extends('layouts.front')
@section('title')
   Contact Us
@endsection
@section('css')
@endsection
@section('content')
    <div class="container text-justify mb-5 contact-us-section">
        <div class="row">
            <div class="col-12">
                <div class="my-5 text-center">
                    <img class="lazyload img-fluid logo-img"
                            src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                            data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" />
                </div>
                <h1 class="text-center mb-5">Contact Us</h1>
                <!-- <h3 class="text-center"> Joven to send Trupal again all the BK Live Official social media information</h3> -->
            </div>
            <div class="col-12">
                  <ul class="contact-social-links">
                      <li>
                            <a href="https://page.line.me/bklive.official" >
                                <i class="fas fa-globe-europe"></i>
                            </a>
                        </li>
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
                          <li>
                            <a href="https://bklive.stream/">
                                <i class="fas fa-link"></i>
                            </a>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
