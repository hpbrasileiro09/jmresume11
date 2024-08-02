
{!! csrf_field() !!}

<div class="row">
	<div class="col-6">
        <div class="form-group">
            <label for="year" class="control-label col-sm-2">Year</label>
            <select id="year" name="year" class="form-select" data-live-search="true">
            @foreach($years as $item)
                <option <?php echo ($item['id'] == $year ? 'selected="selected"' : ''); ?> value="{{$item['id']}}">{{$item['nome']}}</option>
            @endforeach
            </select>
        </div>
    </div>
	<div class="col-6">
        <div class="form-group">
            <label for="month" class="control-label col-sm-2">Month</label>
            <select id="month" name="month" class="form-select" data-live-search="true">
            @foreach($months as $item)
                <option <?php echo ($item['id'] == $month ? 'selected="selected"' : ''); ?> value="{{$item['id']}}">{{$item['label']}}</option>
            @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
	<label for="payments" class="control-label col-sm-2">Payments</label>
	<textarea class="form-control" name="payments" rows="13" cols="80">{{ $payments }}</textarea>
</div>

<div class="form-group">
	<br />
	<input type="submit" value="Reload" class="btn btn-primary" />
</div>

