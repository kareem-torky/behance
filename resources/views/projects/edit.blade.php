@extends('layouts.app')

@section('title')
  Create Developer
@endsection

@section('content')

  @include('inc.errors')

  <div class="row">
    <div class="col-md-6 offset-md-3">

      <form method="POST" action="{{ route('projects.update', $project->id) }}">
        @csrf 
        @method('PUT')
        
        <div class="form-group">
          <label for="exampleInputPassword1">Name</label>
          <input type="text" value="{{ $project->name }}" name="name" class="form-control" id="exampleInputPassword1">
        </div>
        
        <div class="form-group">
          <label for="exampleInputEmail1">Desc</label>
          <textarea name="desc" class="form-control" id="" cols="30" rows="10">{{ $project->desc }}</textarea>
        </div>


        {{-- <div class="form-group">
          <label for="exampleInputPassword1">Images</label>
          <input type="file" name="imgs[]" multiple class="form-control" id="exampleInputPassword1">
        </div> --}}

        @foreach ($devs as $dev)    
          <div class="form-check">
            <input class="form-check-input"  @if(in_array($dev->id, $dev_ids)) checked @endif  name="dev_ids[]" type="checkbox" value="{{ $dev->id }}" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              {{ $dev->name }}
            </label>
          </div>
        @endforeach
        


        
        <button type="submit" class="btn btn-primary">Create</button>
      </form>

    </div>
  </div>
    
@endsection