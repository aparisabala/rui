@extends('admin.layout.main_layout',["tabTitle" => config('i.service_name')." | Update Profile " ])

@section('breadCum')
<div class="py-2">
    <a href="{{ url('admin/dashboard') }}" class="breadcrumb-item"> Admin </a> 
    <span class="breadcrumb-item">  Dashboard  </span> 
    <span class="breadcrumb-item active"> Basic </span>
</div>
@endsection



@section('page')
<div id="pageSideBar" class="pageSideBar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav('pageSideBar')">×</a>
    @include('admin.pages.dashboard.navs.navs')
</div>
<div class="row">
	<div class="col-md-12">
        <div id="defaultPage" class="pages">
            <div class="card rounded-0 pb-3">
                @if ($data['item'] != null)
                    <div class="d-none d-md-block">
                        @include('admin.pages.dashboard.navs.navs')
                    </div>
                    <div class="d-block d-md-none">
                        <div class="d-flex flex-row justify-content-end align-items-center p-2">
                            <span style="font-size:30px;cursor:pointer" onclick="openNav('pageSideBar')">&#9776;</span>
                        </div>
                    </div>
                    <div class="">
                        <h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2"> Update Info ({{  $data['item']->name }}) -  Basic  </h2>
                        <hr class="m-0 mt-4 mb-3">
                        <div class="p-3">
                            @include('admin.pages.dashboard.includes.user_profile')
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
