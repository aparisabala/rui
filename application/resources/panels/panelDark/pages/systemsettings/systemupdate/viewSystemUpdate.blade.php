@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | System Update"])

@section('breadCum')
<div class="py-2">
    <a href="{{ url('admin/dashboard') }}" class="breadcrumb-item"> Admin </a> 
	<span class="breadcrumb-item"> Setup Update </span> 
</div>
@endsection

@section('page')
<div class="row">
	<div class="col-md-12">
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
</div>
@endsection