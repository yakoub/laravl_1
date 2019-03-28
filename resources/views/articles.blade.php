@extends('page')

@section('title', 'Articles')

@section('content')
    <h2> Articles index </h2>

    <form action={{route('export.start')}} method="POST">
        @csrf
        <input type="hidden" value="articles.export" name="route_name" />
        <select name="range">
            <option value="2019-03-01" selected>until 2019-03-01</option>
            <option value="2019-03-20">until 2019-03-20</option>
            <option value="2019-04-10">until 2019-04-10</option>
        </select>
        <button> Export </button>
    </form>

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
