@extends('form')

@section('title', 'Edit article')

@section('content')
    <h2> Edit Article </h2>
    <form action="{{route('article.update', ['article' => $article])}}" method="PATCH">
        @csrf
        <div class="group">
            <div class="field">
            <label for="title"> Title </label>
            <input type="text" name="title" value="{{ $article->title }}"/>
            </div>

            <div class="field">
            <label for="teaser"> Teaser </label>
            <textarea name="teaser"> {{ $article->teaser }} </textarea>
            </div>

            <div class="field">
            <label for="body"> Body </label>
            <textarea name="body"> {{ $article->body }} </textarea>
            </div>
        </div>
        <button type="submit"> Update </button>
    </form>
@endsection
