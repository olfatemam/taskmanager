<div class="w3-row w3-card" style='margin-bottom: 20px'>
<table class="w3-table w3-table-all" >
    <tr>
        <td>
            @if(Auth::user()->is_admin())    
                {{ Form::select('user_id', $users, -1, array('class' => 'form-control', 'placeholder'=>'Select User') ) }}        
            @else
                {{ Form::hidden('user_id', Auth::user()->id) }}        
            @endif            
        </td>            
        <td >{{ Form::text('tag_search', null, array('class' => 'form-control', 'placeholder'=>'Search Tags') ) }}        </td>
        
        <td class="w3-center">Priority:
            @foreach($priorities as $priority)
            <span class="w3-tag w3-border w3-white {{$priority->name}}">
            <input class=" w3-check {{$priority->name}}" type="checkbox" id="priority_id[]" name="priority_id[]" value="{{$priority->id}}" >
            <i class="{{$priority->name}} far fa-flag"></i><label  for="priority_id[]">{{$priority->name}}</label></span>
            @endforeach
        </td>
        <td>
        {{ Form::submit('Search', array('class' => 'btn btn-primary float-right pull-right', 'style'=>'width:100%;vertical-align:middle', 'id'=>'btn_search_packages')) }}
    </td>

    </tr>
</table>
    
</div>
