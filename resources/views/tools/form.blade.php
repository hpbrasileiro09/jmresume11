
{!! csrf_field() !!}

<div class="form-group">
    <label for="year" class="control-label col-sm-5">Year</label>
    <select id="year" name="year" class="form-select" data-live-search="true">
    @foreach($years as $item)
        <option <?php echo ($item['id'] == $year ? 'selected="selected"' : ''); ?> value="{{$item['id']}}">{{$item['nome']}}</option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="month" class="control-label col-sm-5">Month</label>
    <select id="month" name="month" class="form-select" data-live-search="true">
    @foreach($months as $item)
        <option <?php echo ($item['id'] == $month ? 'selected="selected"' : ''); ?> value="{{$item['id']}}">{{$item['label']}}</option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <br />
    <input type="text" class="form-control" style='text-align: right;' id="total" name="total" value="0.0">
</div>

<div class="form-group">
    <br />
    <input id="btn_update" type="submit" value="Reload" class="btnSubmit btn btn-primary" />
</div>

<div class="form-group">
    <br />
    <input id="update_" type="checkbox" name="update" class="form-check-input">&nbsp;<b>Update</b>
</div>

<input type="hidden" id="bag" name="bag" value="">
<input type="hidden" id="action" name="action" value="1">

