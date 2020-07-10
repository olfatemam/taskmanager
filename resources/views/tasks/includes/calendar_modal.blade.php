<div id="mymodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog w3-small">
    <div class="modal-content">
        <div class="modal-header" style='width: 100%'>
            <div class="modal-title pull-left" id="myModalLabel">Add New Task</div>
            <button type="button" class="w3-red close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            
        </div>
        <form class="tagForm" id="tag-form" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                {{ Form::hidden('timezone', "", array('id'=>'timezone') ) }}
                {{ Form::hidden('due', "", array('id'=>'due') ) }}
                {{ Form::hidden('completed', false, array('id'=>'due') ) }}
                <table class='w3-small' style='width: 100%'>
                    <tr><td>{{ Form::text('name', null, array('required', 'class' => 'w3-input w3-border', 'placeholder'=>'task description')) }}</td></tr>
                    <tr><td>{{ Form::text('description', null, array('class' => 'w3-input w3-border', 'placeholder'=>'keywords')) }}</td></tr>
                    <tr><td class="d-flex justify-content-center">
                            <div class="form-group">
                        @foreach(\App\Priority::get() as $priority)
                            <input type="radio" class="w3-radio w3-small" id="priority_id" name="priority_id" value="{{$priority->id}}" checked>
                            <label class="{{$priority->name}}" for="priority_id">{{$priority->name}}</label>
                        @endforeach
                        </div>
                </td ></tr>
                    <tr><td>Remind me: {{ Form::checkbox('reminder', 1, true, array('class' => 'w3-check w3-small', 'style'=>'margin-right:0')) }}</td></tr>
                </table>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input id="newtask-form-submit" type="submit" class="btn btn-primary" value="Add Task">
            </div>
        </form>
    </div>
</div>
</div>
