<?php
if ($data['use_collective'] == 'yes') {
	$text = '
<div class="' . $data['col_width'] . '">
    <!-- Date range -->
    <div class="form-group">
        {!! Form::label(\'{Convention}\',trans(\'{lang}.{Convention}\')) !!}
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            {!! Form::text(\'{Convention}\',old(\'{Convention}\'),[\'class\'=>\'form-control float-right date_time_picker\',\'placeholder\'=>trans(\'{lang}.{Convention}\'),\'readonly\'=>\'readonly\']) !!}
        </div>
        <!-- /.input group -->
    </div>
    <!-- /.form group -->
</div>
';
} else {
	$text = '
<div class="' . $data['col_width'] . '">
    <!-- Date range -->
    <div class="form-group">
        <label>{{trans(\'{lang}.{Convention}\')}}</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" name="{Convention}" value="{{old(\'{Convention}\')}}" class="form-control float-right date_time_picker" readonly="readonly" placeholder="{{trans(\'{lang}.{Convention}\')}}">
        </div>
        <!-- /.input group -->
    </div>
    <!-- /.form group -->
</div>
';
}
$text = str_replace('{Convention}', $data['col_name_convention'], $text);
$text = str_replace('{lang}', $data['lang_file'], $text);
echo $text;
?>