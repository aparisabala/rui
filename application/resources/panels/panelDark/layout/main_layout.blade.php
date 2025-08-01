@php
$r = \Route::getFacadeRoot()->current()->uri();
@endphp
<!DOCTYPE html>
<html lang="en" data-color-theme="dark" class="dark-style layout-menu-fixed">
<head>
    @include('admin.includes.headerResource',['tabTitle' => $tabTitle ?? "Site Title"])
</head>
<body>
	<div class="modal fade editmodal edimodalGlob" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-18 font-bold" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    @include('admin.includes.header')
    @if(config('i.theme.nav') == "topNav")
        @include('admin.includes.navs.main_nav')
    @endif
	<div class="page-content">
        @if(config('i.theme.nav') == "sideNav")
            @include('admin.includes.navs.side_nav')
        @endif
		<div class="content-wrapper">
			<div class="content-inner">
				<div class="page-header page-header-light shadow">
					<div class="page-header-content d-lg-flex">
						<div class="d-flex">
							@yield('pageHeaderLeft')
						</div>
						<div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
							<div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
								@yield('pageHeaderRight')
							</div>
						</div>
					</div>
					<div class="page-header-content d-lg-flex border-top">
						<div class="d-flex">
							<div class="breadcrumb">
								@yield('breadCum')
							</div>
						</div>
						<div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
							<div class="d-lg-flex mb-2 mb-lg-0">
								@yield('breadCumRight')
							</div>
						</div>
					</div>
				</div>
				<div class="content">
                    @yield('page')
				</div>
                @include('admin.includes.footer')
			</div>
		</div>
	</div>
    @include('admin.includes.footerResource', ['react' => $react ?? []])
</body>
</html>