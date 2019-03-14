@extends('page')

@section('title', 'generic form')
@section('style')
    @parent
    form .group .field {
        margin: 2em;
    }
    form .group .field label {
        display:block;
    }
@endsection

@section('content')
 placeholder
@endsection
