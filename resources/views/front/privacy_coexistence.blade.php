@extends('layouts.front')
@section('title')
   Privacy Of Coexistence
@endsection
@section('css')
@endsection
@section('content')
    <div class="container text-justify mb-5">
        <div class="my-5 text-center">
            <img width="200px" class="lazyload img-fluid"
                    src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                    data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" />
        </div>
        <h1 class="text-center mb-5">Privacy Of Coexistence</h1>
    </div>
@endsection

@section('js')

@endsection
