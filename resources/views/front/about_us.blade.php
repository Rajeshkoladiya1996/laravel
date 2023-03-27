@extends('layouts.front')
@section('title')
    About Us
@endsection
@section('css')
@endsection
@section('content')
    <div class="container text-justify mb-5 contact-us-section">
        <div class="row">
            <div class="col-12">
                <div class="my-5 text-center">
                    <a href="{{route('home')}}">
                        <img width="200px" class="lazyload img-fluid logo-img"
                            src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                            data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" />
                    </a>
                    <h1 class="text-center my-5">About Us</h1>
                </div>
            </div>

            <div class="col-12">
                <p>
                    You can download our app from Google Play Store for Android Devices and Apple Store for iOS devices. Here are some Social Media Network links below you may be of interest to you. Thank you for supporting us. If you have any questions, complaints or claims with respect to the Terms or BK Live Singapore Pte Ltd , they should be directed to BK LIVE via <strong>@bklive.support</strong>
                </p>
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
