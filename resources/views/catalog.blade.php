@extends('layouts.app')

@section('title', 'Catalog')

@section('content')
    <div id="content" class="container">
        <div id="files-list" class="files-list">
            {{-- if files empty? --}}
            @foreach ($files as $file)
                <div class="file">
                    <img class="file__preview-img" src="{{ $file->preview }}" alt="preview">
                    <div class="file__info">
                        <a href="/detail/{{ $file->id }}" class="file__info-name">
                            {{ $file->nameUser }}
                        </a>
                        <br>
                        <p class="file__info-size">
                            Size : {{ $file->size }} Kb
                        </p>
                        <p class="file__info-downloads">
                            Downloads: {{ $file->downloads }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="pagination">
        {{-- adding additional query parameters for pagaintion to work properly --}}
        {{ $files->appends([
                '_token' => app('request')->input('_token'),
                'search-input' => app('request')->input('search-input')
            ])->links()
        }}
    </div>

@endsection
