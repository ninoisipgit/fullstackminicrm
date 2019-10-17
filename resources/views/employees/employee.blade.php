@extends('layouts.app')

@section('content')
<employees :user-name={{ Auth::user()->id }} :user-type={{ Auth::user()->user_type }}></employees>
@endsection


