@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-8">
      <img src="/storage/{{ $post->image }}" alt="" class="w-100">  
      </div>
      <div class="col-4">
          <div>
           
          <div class="d-flex align-items-center">
              <div class="pe-3">
                  <img src="/storage/{{ $post->user->profile->image }}" style="max-width: 50px;"  class="rounded-circle w-100">
              </div> 
              <div>
                  <div class="fw-bold">
                      <a href="/profile/{{ $post->user->id}}" class="text-dark text-decoration-none">{{ $post->user->username }}</a></div}>
                      <a href="" class="ps-3 text-decoration-none" >Follow</a>
              </div>
          </div>
          </div>
          <hr>

          <p><span class="fw-bold"><a href="/profile/{{ $post->user->id}}" class="text-dark text-decoration-none">
              {{ $post->user->username }}</a></span>{{ $post->caption }}</p>
          </div>
      </div>
  </div>
</div>              
@endsection

