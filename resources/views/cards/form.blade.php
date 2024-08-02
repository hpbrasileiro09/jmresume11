
{!! csrf_field() !!}

<?php 
$vltotal = 0.0;
foreach($registers as $register) {
    if ($register->status == 1) {
        $vltotal += $register->vl_entry;
    }
}
?>

<div class="form-group">
    <label for="year" class="control-label col-sm-4">Year</label>
    <select id="year" name="year" class="form-select" data-live-search="true">
    @foreach($years as $item)
        <option <?php echo ($item['id'] == $year ? 'selected="selected"' : ''); ?> value="{{$item['id']}}">{{$item['nome']}}</option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="month" class="control-label col-sm-4">Month</label>
    <select id="month" name="month" class="form-select" data-live-search="true">
    @foreach($months as $item)
        <option <?php echo ($item['id'] == $month ? 'selected="selected"' : ''); ?> value="{{$item['id']}}">{{$item['label']}}</option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="day" class="control-label col-sm-4">Cards</label>
    {!! $cartoes !!}
</div>

<div class="form-group">
    <br />
    <input type="text" class="form-control" style='text-align: right;' id="total" name="total" value="{{ $vltotal }}">
</div>

<div class="form-group">
    <br />
    <input type="text" class="form-control" style='text-align: right;' id="geral" name="geral" value="{{ $vltotal }}">
</div>

<div class="form-group">
	<br />
	<input type="submit" value="Reload" class="btn btn-primary" />
</div>

<input type="hidden" id="bag" name="bag" value="">
<input type="hidden" id="action" name="action" value="1">

