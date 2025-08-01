@extends('admin.layout.full_page_layout',["tabTitle" => config('i.service_name')." | Reset Password "])
@section('page')
<div class="page-content pt-0">
    <div class="content-wrapper">
        <div class="content">
            <div class="row center-box">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
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
                                        <button class="btn btn-outline-orange d-grid w-100 text-white" type="submit"> SEND CODE </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

