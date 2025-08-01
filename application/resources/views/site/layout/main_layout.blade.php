<!DOCTYPE html>
<html lang="en" class="dark-style layout-menu-fixed" dir="ltr">

<head>
    @include('site.includes.headerResource', ['tabTitle' => $tabTitle ?? 'Site Title'])
</head>

<body>
    <!-- Modal -->
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
    <div id="">
        @include('site.includes.header')
            @yield('page')
        @include('site.includes.footer')
    </div>
    @include('site.includes.footerResource', ['react' => $react ?? []])
</body>
</html>
