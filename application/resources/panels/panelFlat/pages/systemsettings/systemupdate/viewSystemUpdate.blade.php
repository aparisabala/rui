@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | System User"])
@section('page')
<div class="thepage">
	<div class="bread-cum">
        <h4 class="fw-bold py-3 mb-4 "><span class="text-muted fw-light text-orange">
            System Update / 
            <span class="text-muted"> New Update   </span> 
        </h4>
	</div>
    <div id="defaultPage" class="pages"> 
        <div class="card rounded-0 pb-3">
            <h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2"> Update Your System </h2>
            <hr class="m-0 mt-2">
            <div class="mt-2 p-2 p-md-4">
               <div class="col-md-4 offset-md-4">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading"> Warnning, Procced With Caution </h4>
                        <p>This will update the system according to the need, this process is not revesable, proceed with cautions </p>
                        <hr>
                        <p class="text-danger"> DO NOT REFRESH OR CLOSE THIS WINDOW</p>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="onPressUpdate"> Start Process </button>
                    </div>
                    <div id="status" class="text-center">Updated Data Of : 
                        <span id="currentTable"></span> <br>
                        Currently Procced Of: <span id="updateCount">0</span>/15 <br>
                        Time Elapsed: <span id="took"></span>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection