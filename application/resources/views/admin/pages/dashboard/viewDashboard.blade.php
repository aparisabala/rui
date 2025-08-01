@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | Dashboard" ])

@section('breadCum')
    <div class="py-2">
        <a href="#" class="breadcrumb-item">B1</a>
        <span class="breadcrumb-item">B2</span>
        <span class="breadcrumb-item active">B3</span>
    </div>
@endsection
@section('page')
<div class="row">
	<div class="col-md-12">
		<div class="card rounded-0 pb-3">
			{{-- pageNav --}}
			<h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2">  Welcome User  </h2>
			<hr class="m-0 mt-2">
			<div class="mt-2 p-2 p-md-4">
			</div>
		</div>
	</div>
</div>
@endsection
