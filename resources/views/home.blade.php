@extends('page')

@section('title', 'Homepage')

@section('content')
    <h2> Lar1 homepage </h2>
    <section>
        <header>
            {{ $greeting }}
        </header>
        <p>
            {{ $message }}
        </p>
    </section>
@endsection
