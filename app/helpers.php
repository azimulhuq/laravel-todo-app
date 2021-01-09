<?php

if(!function_exists('getCurrentTime')) {
    /**
     * @return string
     */
    function getCurrentTime() {
        return (new DateTime())->format("Y-m-d h:i:s");
    }
}

if(!function_exists('getTaskStatus')) {
    /**
     * @param \App\Models\Task $task
     */
    function getTaskStatus(\App\Models\Task $task) {
        if($task->end_time < getCurrentTime()) {
            return array_search(config('status.Completed'), config('status'));
        }
        return array_search($task->status, config('status'));
    }
}
