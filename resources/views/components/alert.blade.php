<div>
    <div  class="alert alert-{{$type}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-{{$icon}}"></i> {{$title}}!</h4>
        {{$slot}}.
    </div>
</div>