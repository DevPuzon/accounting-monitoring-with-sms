
<h5>@lang('Mass upload Excel')</h5>
<form action="{{url('fees/generated-form/import')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }} 
    <div class="form-group">
        <input type="file" name="file">
    </div>
    <input type="submit" class="btn btn-default btn-sm" value="@lang('Bulk upload')">
</form>
