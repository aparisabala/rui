@extends('admin.layout.main_layout', ["tabTitle" => config('i.service_name')." | Admin | Setup Profile" ])

@section('breadCum')
<div class="py-2">
    <a href="{{ url('admin/dashboard') }}" class="breadcrumb-item"> Admin </a> 
	<span class="breadcrumb-item"> Setup Profile </span> 
</div>
@endsection

@section('page')
<div class="row">
	<div class="col-md-12">
		<div id="defaultPage" class="pages">
			<div class="card rounded-0 pb-3">
				@if ($data['item'] != null)
					<div class="">
						<h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2">
							Setup Profile ({{  $data['item']->name }})  </h2>
						<hr class="m-0 mt-4 mb-3">
						<div class="p-3">
							@include('admin.pages.setup.includes.profile_setup_form')
						</div>
					</div>
				@else
					@include('common.view.NotFoundFragment')
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
