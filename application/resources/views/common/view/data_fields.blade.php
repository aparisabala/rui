<input type="hidden" value="{{ config('a.lang') }}" id="l">
<input type="hidden" value="{{ config('i.service_name') }}" id="service_name">
<input type="hidden" value="{{ config('i.service_domain') }}" id="service_domain">
<input type="hidden" value="{{ (config('r')) ? implode("_",config('r')) : "" }}" id="roles">