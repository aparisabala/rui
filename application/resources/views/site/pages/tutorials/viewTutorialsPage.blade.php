@extends('site.layout.main_layout',["tabTitle" => config('i.service_name')." | Welcome " ])
@section('page')
    <main class="main">
        <section id="portfolio" class="portfolio section">
            <div class="container">
                <h2> Tutorials </h2>
                <div class="row">
                    @foreach ($data['items'] as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="portfolio-content h-100 cursor-pointer" onclick="window.location.href=''">
                                <img src="{{getThumbnail($item,'640X360')}}" class="w-100" alt="">
                                <div class="portfolio-info">
                                    <h4>{{$item?->name}}</h4>
                                </div>
                            </div>
                            <h4 class="tetx-orange">{{$item?->name}}</h4>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{  $data['items']->links('site.pages.pagination.customPagination') }}
                </div>
            </div>
        </section>
  </main>
@endsection