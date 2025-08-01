@php
    $img = url('statics/images/system/no_data.jpg');
    if(isset($cus_image)) {
		$img = url($cus_image);
	}
@endphp
<div class="d-flex flex-row justify-content-center align-items-center" style="height: 250px;">
    <div class="d-block text-center">
        @if(!isset($image))
        <img src="{{ $img  }}" style="width: 200px;">
        @endif
        <h6 class="text-center"> <b>{{ $title }}</b> </h6>
        <p class="text-center fs-12"> {!! $message !!}</p>
        @if($url  != "no")
        <p class="mb-0"><a href="{{ url($url) }}"> <button class="btn btn-primary"> {{ $btn_text }} </button></a></p>
        @endif
    </div>
</div>