@extends('layouts.app')

@section('content')
<div class="container">
	<form class="form-horizontal" method="POST" action="{{ action('Admin\MachineController@update', [$machine->id]) }}">
		<div class="form-group">
			<label class="col-sm-2 control-label">ID</label>
			<div class="col-sm-10">
				<p class="form-control-static">{{ $machine->id }}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Group</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="group" value="{{ $machine->group }}" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Hostname</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="hostname" value="{{ $machine->hostname }}" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">CPUs</label>
			<div class="col-sm-3">
				<input type="number" class="form-control" name="cpus" value="{{ $machine->cpus }}" min="0">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Memory</label>
			<div class="col-sm-3">
				<input type="number" class="form-control" name="memory" value="{{ $machine->memory }}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="PATCH">
				<button class="btn btn-primary" type="submit">Update</button>
			</div>
		</div>
	</form>
	<table class="table">
		@foreach ($machine->scopes as $scope)
		<tr>
			<td><code>{{ $scope->token }}</code></td>
			<td>
				<form action="{{ action('Admin\MachineScopeController@destroy', [$machine->id, $scope->id]) }}" method="POST" style="display: inline-block;">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="DELETE">
					<button type="submit" class="btn btn-danger" onclick="return confirm('Remove token?')">Delete</button>
				</form>
			</td>
		</tr>
		@endforeach
		<tr>
			<td></td>
			<td>
				<form action="{{ action('Admin\MachineScopeController@store', [$machine->id]) }}" method="POST">
					{{ csrf_field() }}
					<button type="submit" class="btn btn-success">Create new token</button>
				</form>
				
			</td>
		</tr>
	</table>
</div>
@endsection
