@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | Not Found "])

@section('breadCum')
<div class="py-2">
    <a href="{{ url('admin/dashboard') }}" class="breadcrumb-item"> Admin </a> 
	<span class="breadcrumb-item"> Not Found </span> 
</div>
@endsection

@section('page')
<div class="row">
	<div class="col-md-12">
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
</div>
@endsection