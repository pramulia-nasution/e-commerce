@if ($message = Session::get('success'))
<x-alert type="success" icon="check" title="Sukses">{{$message}}</x-alert>
@endif

@if ($message = Session::get('error'))
<x-alert type="danger" icon="ban" title="Error">{{$message}}</x-alert>
@endif

@if ($message = Session::get('warning'))
<x-alert type="warning" icon="warning" title="Warning">{{$message}}</x-alert>
@endif

@if ($message = Session::get('info'))
<x-alert type="info" icon="info" title="Informasi">{{$message}}</x-alert>
@endif