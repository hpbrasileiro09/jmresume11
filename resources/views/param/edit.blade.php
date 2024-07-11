<x-app-layout>

<div class="row">
<div class="col-6">

<div class="card mt-5" style="background-color: lightgray;">
  <h2 class="card-header">Update Param</h2>
  <div class="card-body">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
        <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
        <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
        <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
    </div>
    <form action="{{ route('param.update', $register->id) }}" class="form-horizontal" method="post">
        <input type="hidden" name="_method" value="PUT">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12">
                <div class="form-group{{ $errors->has('agora') ? ' has-error' : '' }}">
                    <label for="agora" class="control-label col-sm-4">Now</label>
                    <input type="date" name="agora" id="agora" class="form-control" value="{{ $register->value }}" placeholder="Now...">
                    @if ($errors->has('agora'))
                        <span class="help-block">
                            <strong>{{ $errors->first('agora') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <br />
            <input type="submit" value="Save" class="btn btn-primary" />
            <a class="btn btn-success" href="{{ route('entry.index') }}">Back</span></a>
        </div>
    </form>
  </div>
</div>  

</div> <!--div class="col-X"-->
<div class="col-6">
</div>
</div> <!--div class="row"-->

</x-app-layout>