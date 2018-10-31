@extends('layouts.app')

@section('title', 'Load and search files')

@section('content')
    {{-- check if exists --}}
    <p class="flash-message">{{$message}}</p>
    <div id="content" class="index-container">
        <div class="icon-upload-file index-container__icon"></div>
        <form action="/proccess" id="js-upload" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="file" name="file-input" id="js-file-input">
            <input type="submit" value="Submit">
        </form>
        <p class="index-container__note">Max. size: 8mb</p>
        <div id="js-upload-error-block" class="index-container__error-message">
            <p id="js-upload-error-text"></p>
        </div>
        @if ($errors->any())
            <div id="backend-error-block" class="error-block">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

@endsection
