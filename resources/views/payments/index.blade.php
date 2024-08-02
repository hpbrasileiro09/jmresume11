<x-app-layout>

<div class="row">
<div class="col-7">
    
<div class="card mt-3" style="background-color: lightgray;">
  <h2 class="card-header">Payments</h2>
  <div class="card-body">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
        <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
        <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
        <a href="{{ route('param.edit', 1) }}"><span data-feather="settings"></span></a>
        <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
    </div>
    <form action="{{ route('payments.index') }}" class="form-horizontal" method="get">
        <input type="hidden" name="_method" value="GET">
        @include('payments.form')
    </form>
  </div>
</div>  

</div> <!--div class="col-X"-->
<div class="col-5">
</div>
</div> <!--div class="row"-->

</x-app-layout>