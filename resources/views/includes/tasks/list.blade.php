@if(count($tasks) <= 0)
    You dont have any task created yet!!
    Maybe, <a href="{{route('task.create')}}">Create</a> one?
@else
    <div class="row">
        @foreach($tasks as $task)
            <div class="col-md-4" style="padding-top: 10px">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$task->name}}</h5>
                        <p class="card-text">{{$task->description}}</p>
                        <div style="display: flex; justify-content: space-between">
                            <p>Status: <span class="badge badge-success">{{getTaskStatus($task)}}</span></p>
                            @if((getTaskStatus($task) !== "Completed") || ($task->end_time > getCurrentTime()))
                                <form id="form-{{$task->id}}" method="post"
                                      action="@if(getTaskStatus($task) == "Pending")
                                      {{route('task.complete', ['id' => $task->id])}}
                                      @else
                                      {{route('task.pending', ['id' => $task->id])}}
                                      @endif">
                                    @csrf
                                    <input type="checkbox" class="form-check" id="{{$task->id}}" onchange="changeTaskStatus({{$task->id}})">
                                </form>
                            @endif
                        </div>
                        <p>Ends at: <br><span class="text-primary">{{date('H:i a, d-m-Y', strtotime($task->end_time))}}</span></p>
                        <div style="display: flex; justify-content: space-between; padding-top: 10px">
                            <a href="{{route('task.edit', ['id' => $task->id])}}" class="btn btn-outline-info">Edit</a>
                            <form action="{{route('task.delete', ['id' => $task->id])}}" method="post">
                                @csrf
                                <button type="submit" onclick="return(confirm('Are you sure to delete?'))" class="btn btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        function changeTaskStatus(taskId) {
            const form = document.getElementById(`form-${taskId}`);
            form.submit();
        }
    </script>
@endif


