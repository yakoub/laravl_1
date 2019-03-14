@extends('form')

@section('title', 'Create an article')

@section('content')
    <h2> Create an article </h2>
    <form action="{{route('article.store')}}" method="POST">
        @csrf
        <div class="group">
            <div class="field">
            <label for="title"> Title </label>
            <input type="text" name="title" />
            </div>

            <div class="field">
            <label for="teaser"> Teaser </label>
            <textarea name="teaser"></textarea>
            </div>

            <div class="field">
            <label for="body"> Body </label>
            <textarea name="body"></textarea>
            </div>
        </div>
        <button type="submit"> Create </button>
    </form>
@endsection
