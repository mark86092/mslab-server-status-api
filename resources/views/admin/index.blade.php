@extends('layouts.app')

@section('content')
<div class="container">
	<form class="form-horizontal" method="POST" action="{{ action('Admin\AdminController@updateProfile') }}">
		<div class="form-group">
			<label class="col-sm-2 control-label">email</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="email" value="{{ $user->email }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">password</label>
			<div class="col-sm-3">
				<input type="password" class="form-control" name="password" value="">
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
</div>
@endsection
