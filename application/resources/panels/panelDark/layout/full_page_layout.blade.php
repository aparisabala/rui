@php
$r = \Route::getFacadeRoot()->current()->uri();
@endphp
<!DOCTYPE html>
<html lang="en" data-color-theme="dark" class="light-style layout-menu-fixed">

<head>
    @include('admin.includes.headerResource',['tabTitle' => $tabTitle ?? "Site Title"])
</head>

<body>
    @yield('page')
    @include('admin.includes.footerResource',["react"=>$react ?? []])
</body>

</html>