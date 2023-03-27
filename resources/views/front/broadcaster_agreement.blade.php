@extends('layouts.front')
@section('title')
    Broadcaster Agreement
@endsection
@section('css')
@endsection
@section('content')
    <div class="container text-justify mb-5">
        <div class="my-5 text-center">
            <a href="{{route('home')}}">
                <img class="lazyload img-fluid logo-img"
                    src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                    data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" />
            </a>
        </div>
        <h1 class="text-center my-5">Broadcaster Agreement</h1>
    </div>
@endsection

@section('js')

@endsection
