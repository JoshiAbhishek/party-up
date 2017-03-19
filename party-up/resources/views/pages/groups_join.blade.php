@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
        <div>
{{ Form::open(array('url' => '/Groups/join')) }}

{{ Form::text('code') }}

{{ Form::submit('Join') }}

{{ Form::close() }}
        </div>
@endsection

