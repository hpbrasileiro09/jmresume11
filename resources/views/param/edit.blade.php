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
        <input type="hidden" name="tipo" value="0">
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

<!--
<div class="card mt-5" style="background-color: yellow;">
  <h2 class="card-header">Generate Entries</h2>
  <div class="card-body">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
        <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
        <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
        <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
    </div>
    <form action="{{ route('param.generate') }}" class="form-horizontal" method="post">
        <input type="hidden" name="_method" value="GET">
        <input type="hidden" name="tipo" value="0">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-4">
                <div class="form-group{{ $errors->has('ano') ? ' has-error' : '' }}">
                    <label for="ano" class="control-label col-sm-4">Ano</label>
                    <input type="number" name="ano" id="ano" class="form-control" value="{{ $ano }}" placeholder="Ano...">
                    @if ($errors->has('ano'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ano') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-4">
                <div class="form-group{{ $errors->has('mes') ? ' has-error' : '' }}">
                    <label for="mes" class="control-label col-sm-4">Mês</label>
                    <input type="number" name="mes" id="mes" class="form-control" value="{{ $mes }}" placeholder="Mês...">
                    @if ($errors->has('mes'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mes') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-4">
                <div class="form-group{{ $errors->has('times') ? ' has-error' : '' }}">
                    <label for="times" class="control-label col-sm-4">Times</label>
                    <input type="number" name="times" id="times" class="form-control" value="{{ $times }}" placeholder="Times...">
                    @if ($errors->has('times'))
                        <span class="help-block">
                            <strong>{{ $errors->first('times') }}</strong>
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
-->  

</div>
</div> <!--div class="row"-->

</x-app-layout>