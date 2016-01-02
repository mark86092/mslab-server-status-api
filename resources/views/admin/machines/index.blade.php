@extends('layouts.app')

@section('content')
<div class="container">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Hostname</th>
				<th>CPUs</th>
				<th>Memory</th>
				<th>Last Update</th>
				<th>Update token (token)</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($machines as $machine)
			<tr>
				<td>{{ $machine->id }}</td>
				<td>{{ $machine->hostname }}</td>
				<td>{{ $machine->cpus }}</td>
				<td>{{ $machine->memory }}</td>
				<td>{{ $machine->updated_at }}</td>
				<td>
@foreach ($machine->scopes as $scope)
<code>{{ $scope->token }}</code>
@endforeach
				</td>
				<td>
					<a href="{{ action('Admin\MachineController@edit', [$machine->id]) }}" class="btn btn-default btn-sm">Edit</a>
					
					<form action="{{ action('Admin\MachineController@destroy', [$machine->id]) }}" method="POST" style="display: inline-block;">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="DELETE">
						<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete it?')">Delete</button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<form action="{{ action('Admin\MachineController@store') }}" method="POST">
			<tr>
				<td></td>
				<td><input type="text" class="form-control" required name="hostname"></td>
				<td><input type="number" class="form-control" min="0" name="cpus"></td>
				<td><input type="number" class="form-control" min="0" name="memory"></td>
				<td></td>
				<td></td>
				<td>{{ csrf_field() }}<button type="submit" class="btn btn-default btn-sm">Create</button></td>
			</tr>
			</form>
		</tfoot>
	</table>
<p>Script: </p>
<pre>
#!/bin/bash

token=secret

load=(`cat /proc/loadavg | cut -f '1 2 3' -d " "`)
memory_using=$(free | awk '/cache:/{print $3}')

curl -X PATCH -d "load1=${load[0]}&load5=${load[1]}&load15=${load[2]}&memory_using=${memory_using}&token=${token}" "{{ action('MachineController@update') }}"
</pre>
</div>
@endsection
