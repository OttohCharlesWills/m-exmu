@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto px-4 py-6">

    <h2>Welcome {{ Auth::user()->name }}</h2>


</div>
@endsection
