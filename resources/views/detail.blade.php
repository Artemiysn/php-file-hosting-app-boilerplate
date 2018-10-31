@extends('layouts.app')

@section('title', 'Catalog')

@section('content')
        <div class="detail">
            <div class="detail__preview">
                <img src="{{ $file['preview'] }}" alt="preview" >
            </div>
            <div class="detail__title">
                <a href="/download/{{$file['id']}}">{{$file['nameUser']}}</a>
                <p> Size: {{$file['size']}} Kb </p>
            </div>
            <div class="detail__stats">
                <p> Downloads: {{$file['downloads']}}</p>
            </div>
        </div>
        <h4>Commentaries:</h4>
        <hr>
        <div class="commentaries">
            @foreach($commentaries as $commentary)
                <b>{{ $commentary['name']}}:</b>
                <br>
                <p>{{ $commentary['content']}}</p>
                <hr>
            @endforeach
        </div>
        <form class="form" id="js-commentary-form" name="add-commentary" method="GET" action="/comment/{{ $file['id'] }}">
            Add Commentary: <br>
            <input id="js-commentary-name" type="text" name="name" placeholder="Your Name:">
            <br><br>
            <input id="js-commentary-text" type="text" name="userCommentaryInput" placeholder="Commentary..">
            <br><br>
            <input type="submit" value="Submit">
        </form>
        <div id="js-commentary-error-block" class="error-message">
            <p id="js-commentary-error-text"></p>
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
@endsection
