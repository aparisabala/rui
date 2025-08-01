<div class="d-flex flex-row justify-content-center align-items-center" style="height: 250px;">
    <div class="d-block text-center">
    	<img src="{{  url('statics/images/system/no_data.jpg') }}" style="width: 200px;">
		<h6 class="text-center"> <b>  {{ Lang::get('common.no_access') }} </b> </h6>
		<p class="text-center"> 
			 <a href="{{ url('admin/dashboard') }}"> <button class="btn btn-primary"> {{ Lang::get('common.no_access_button') }} </button>   </a>
		 </p>
    </div>
</div>