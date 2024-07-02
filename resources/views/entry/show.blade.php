<x-app-layout>

<div class="card mt-5" style="background-color: lightgray;">
	<h2 class="card-header">Entry Detail</h2>
	<div class="card-body">
		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			<a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
			<a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
			<a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
			<a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
		</div>
		<?php echo $alert; ?>
		<h4>
			<b>Description:</b>&nbsp;
			<pre><?php echo $prehtml ?></pre>
		</h4>
		<div class="row">
			<div class="col-6">
				<a href="{{ route('entry.edit', $register->id) }}" class="btn btn-primary">Edit</a>
			</div>
			<div class="col-6" style="text-align: right;">
				<form action="{{ route('entry.destroy', $register->id) }}" method="post">
					{!! csrf_field() !!}
					<input type="hidden" name="_method" value="DELETE">
					<input type="submit" value="remover" class="btn btn-danger">
				</form>
			</div>
		</div>
	</div>
</div>

</x-app-layout>