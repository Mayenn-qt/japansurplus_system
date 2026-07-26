@extends('layouts.app')

@section('title','Staff Dashboard')

@section('content')

<div class="container mt-5">

    <h1>Staff Dashboard</h1>

    <h5>Welcome {{ Auth::user()->name }}</h5>

    <p>Branch ID : {{ Auth::user()->branch_id }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button class="btn btn-danger">
            Logout
        </button>

    </form>

</div>

@endsection