@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | Not Found "])
@section('page')
<div class="thepage">
	<div class="bread-cum">
		<h4 class="fw-bold py-3 mb-4">
			<span class="text-muted fw-light text-orange">
				Exceptions / 
				<span class="text-muted"> Not Item Not Found   </span> /
			</span>
		</h4>
	</div>
	<div id="defaultPage" class="pages">
		<div class="card rounded-0 pb-3">
			<div class="d-flex flex-row justify-content-center align-items-center" style="height: 500px;">
				<div class="d-block text-center">
					<img src="{{  url('statics/images/system/404.png') }}" style="width: 400px;">
					<h6 class="text-center"> <b> Item not found Try again</b> </h6>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection