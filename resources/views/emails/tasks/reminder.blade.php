@component('mail::message')
# Task {{$task->name}} Reminder

{{$task->description}}
{{$task->due . ' ' .$task->tzone}}

Thanks,<br>
{{ config('app.name') }}

@endcomponent
