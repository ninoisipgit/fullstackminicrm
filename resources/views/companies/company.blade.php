@extends('layouts.app')

@section('content')
<companies :user-name={{ Auth::user()->id }} :user-type={{ Auth::user()->user_type }}></companies>
@endsection


