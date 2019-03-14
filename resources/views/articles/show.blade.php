@extends('page')

@section('title', $article->title)

@section('content')
    <section>
        <header>
            <h3> <a href="{{ route('article.show', ['article' => $article]) }}">
                {{ $article->title }} 
             </a> </h3>
            {{ $article->teaser }}
        </header>
        <p>
            {{ $article->body }}
        </p>
    </section>
    <a href="{{ route('article.edit', ['article' => $article]) }}"> Edit </a>
@endsection
