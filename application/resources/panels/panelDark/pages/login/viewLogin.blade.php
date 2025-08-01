@extends('admin.layout.full_page_layout',["tabTitle" => config('i.service_name')." | Admin Login"])
@section('page')
<div class="page-content pt-0">
    <div class="content-wrapper">
        <div class="content">
            <div class="row center-box">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            @include('common.view.fragments.ErrorViewBS5')
                            <h1 class="mb-3 text-center fs-24"> PARAMETER-X LOGIN  </h1>
                            <form id="frmAdminLogin" autocomplete="off" novalidate>
                                <div class="mb-3">
                                    <label class="form-label"><strong> Mobile or Email </strong> <em class="required">*</em> <span id="mobile_number_error"></span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ph ph-user"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Mobile Number or Email" name="mobile_number" id="mobile_number">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong> Password </strong> <em class="required">*</em> <span id="password_error"></span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ph ph-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-3">
                                    <p class="me-auto">
                                        <span> <input type=checkbox name="remember"> </span> <span class="ms-2"> Remember me </span>
                                    </p>
                                    <button type="submit" class="btn btn-outline-orange text-dark"> Login </button>
                                </div>
                                <div class="d-flex justify-content-start align-items-center">
                                    <p class="p-0">
                                        <a class="link-indigo " href="{{ url('admin/reset')}}"><span class=""> Forgot password ? </span></a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection