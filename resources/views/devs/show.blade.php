@extends('layouts.app')

@section('title')
  Show - {{ $dev->name }}
@endsection

@section('content')

  <div class="row">
    <div class="col-md-6 offset-md-3">
      <img src='{{ asset("uploads/devs/$dev->img") }}' class="w-100">
      <h5>{{ $dev->name }}</h5>
      <p>{{ $dev->spec }}</p>
      <p>{{ $dev->email }}</p>

      <a href="{{ route('devs.index') }}">Back</a>
    </div>
  </div>
    
  @foreach ($dev->projects as $project)
      <h1>{{ $project->name }}</h1>
  @endforeach

@endsection