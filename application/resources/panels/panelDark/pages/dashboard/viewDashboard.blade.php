@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | Welcome User" ])

@section('breadCum')
	<div class="py-2">
		<a href="#" class="breadcrumb-item">Admin</a>
		<span class="breadcrumb-item active">Welcome</span>
	</div>
@endsection

@section('page')
<div class="row">
	<div class="col-md-12">
		<div id="defaultPage" class="pages">
			<div class="tool-box d-flex flex-row justify-content-end align-items-center">
			</div>
			<div class="card rounded-0 pb-3">
				{{-- pageNav --}}
				<h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2">  Welcome User  </h2>
				<hr class="m-0 mt-2">
				<div class="mt-2 p-2 p-md-4">
					Welcome
				</div>
			</div>
		</div>
	</div>
</div>
@endsection