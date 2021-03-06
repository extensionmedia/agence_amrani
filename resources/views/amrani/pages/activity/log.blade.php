@extends('amrani.layout.app')
@section('title') {{ __('Activity') }} @endsection

@section('content')
    <div class="w-full h-full bg-gray-100">
        <div class="flex items-center justify-between h-12 px-4 text-gray-600 bg-white">
            <h1 class="font-bold text-xl">{{ __('Activity') }} </h1>
        </div>

        @include('amrani.pages.activity.partials.table')


    </div>
@endsection