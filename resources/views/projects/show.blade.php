@extends('layouts.app')

@section('title')
  Show - {{ $project->name }}
@endsection

@section('content')

  <div class="row">
    <div class="col-md-6 offset-md-3">

      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @foreach ($project->imgs as $img)              
          <div class="carousel-item @if($loop->iteration == 1) active @endif">
            <img src='{{ asset("uploads/projects/$img->name") }}' class="d-block w-100" alt="...">
          </div>
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <h5>{{ $project->name }}</h5>
      <p>{{ $project->desc }}</p>

      @foreach ($project->devs as $dev)
          <h1>{{ $dev->name }}</h1>
      @endforeach

      <a href="{{ route('projects.index') }}">Back</a>
    </div>
  </div>

@endsection