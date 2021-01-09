@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between">
                        <p>{{ __('Dashboard') }}</p>
                        <a href="{{route('task.create')}}"><strong>+</strong></a>
                    </div>
                    <div class="card-body">
                        @include('includes.tasks.list')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
