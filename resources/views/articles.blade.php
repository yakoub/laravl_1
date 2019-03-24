@extends('page')

@section('title', 'Articles')

@section('content')
    <h2> Articles index </h2>
     <a href="{{ route('articles.export') }}"> export </a>
    @foreach ($articles as $article)
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
    @endforeach
    {{ $articles->links() }}
@endsection
