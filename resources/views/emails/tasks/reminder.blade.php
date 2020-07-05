@component('mail::message')
# Task {{$task->name}} Reminder

{{$task->description}}
{{$task->due . ' ' .$task->timezone}}

Thanks,<br>
{{ config('app.name') }}

@endcomponent
