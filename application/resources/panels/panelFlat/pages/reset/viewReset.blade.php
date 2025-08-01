@extends('admin.layout.full_page_layout',["tabTitle" => config('i.service_name')." | Reset Password "])
@section('page')
<div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
        <div class="card" style="background-color: rgba(0,0,0,.7)">
            <div class="card-body">
                <div class="app-brand justify-content-center">
                    <a href="{{ url('/admin/login') }}" class="app-brand-link gap-2">
                        <img src="{{ config('i.logo') }}" style="width: 70px;">
                    </a>
                </div>
                @include('common.view.fragments.ErrorViewBS5')
                <div id="resetBase">
                    <h4 class="mb-4 text-center fs-30 text-white"> RESET  PASSWORD </h4>
                    <form id="frmSendAdminCode" class="mb-3" autocomplete="off" method="POST">
                        <div class="form-group text-left mb-3">
                            <label class="form-label text-white" for="mobile_number"> <b>  Mobile Number </b> <em class="required">*</em> <span id="mobile_number_error"> </span></label>
                            <div class="input-group">
                                <input type='text' class="form-control" name="mobile_number" id="mobile_number" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100 text-white" type="submit"> SEND CODE </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

