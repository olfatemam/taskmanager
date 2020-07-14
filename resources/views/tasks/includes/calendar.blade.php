<style>
<?php
foreach(\App\Priority::get() as $priority)
{
    echo PHP_EOL .'.' . $priority->name .
            '{'. 
            'background-color: '. $priority->background_color .';'.
            'color: '. $priority->text_color .';'.
            '}' ;
}
?>
    
</style>

<div id='calendar'></div>


<div id="mymodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog w3-small">
    <div class="modal-content">
        <div class="modal-header" style='width: 100%'>
            <div class="" id="datetimezone" style="float:right"></div>
            <button type="button" class="w3-red close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <form class="tagForm" id="tag-form" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                {{ Form::hidden('timezone', "", array('id'=>'timezone') ) }}
                {{ Form::hidden('due', "", array('id'=>'due') ) }}
                {{ Form::hidden('task_id', 0, array('id'=>'task_id') ) }}
                
                <table class='w3-table' style='width: 100%'>
                    <tr>
                        <th class="" style="vertical-align: middle;width:20%">Name</th>
                        <td style="width:80%">{{ Form::text('name', null, array('id'=>'name', 'required', 'class' => 'w3-input', 'placeholder'=>'New Task Name')) }}
                        </td></tr>
                    <tr>
                        <th class="" style="vertical-align: middle;width:20%">Keywords</th>
                        <td style="width:80%">{{ Form::text('description', null, array('id'=>'description', 'class' => 'w3-input', 'placeholder'=>'Keywords')) }}</td>
                    </tr>
                </table>
                <table class='w3-table' style='width: 100%'>
                    <tr>
                    <td colspan="3" class="w3-small w3-center">
                        <table  class="w3-table" style="width:100%">
                        <tr class="w3-border">
                        <td style="float:right;"><label>Priority</label></td>    
                        @foreach(\App\Priority::get() as $priority)
                        <td><input type="radio" class="{{$priority->name}}" id="priority_id" name="priority_id" value="{{$priority->id}}" checked>
                            <label class="w3-tag w3-white" for="priority_id">{{$priority->name}}</label>
                        </td>
                        @endforeach
                        </tr>
                        
                        </table>
                    </td>
                        
                    </tr>
                    <tr>
                    <td colspan="3" class="w3-small w3-center">
                        <table  class="w3-table" style="width:100%">
                        <tr class="w3-border">
                        <td style="float:right;"><label></label></td>
                        <td><div><label style="" class="float-right">Remind Me!</label>{{ Form::checkbox('reminder', 1, true, array('class' => 'float-right', 'style'=>"margin-right:10px;")) }}</div>
                        </td>
                        <td><div id="completed_div"><label style="" class="float-right">Mark Completed</label>{{ Form::checkbox('completed', 1, false, array('id'=>'completed', 'class' => 'float-right', 'style'=>"margin-right:10px;")) }}</div>
                        </td>
                        </tr>
                    </table>
                    </td>
                </tr>
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
