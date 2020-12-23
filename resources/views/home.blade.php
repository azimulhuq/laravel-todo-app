@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($tasks) <= 0)
                        You dont have any task created yet!!
                        Maybe, <a href="">Create</a> one?
                    @else
                        <div class="row">
                            @foreach($tasks as $task)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$task->name}}</h5>
                                            <p class="card-text">{{$task->description}}</p>
                                            <span class="text-primary">Ends at: {{$task->end_time}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
