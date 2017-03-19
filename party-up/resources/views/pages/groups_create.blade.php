@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
        <div>
<h2>Create Group</h2>
{{ Form::open(array('url' => '/Groups/create')) }}
Name:
{{ Form::text('name') }}

{{ Form::submit('Create') }}

{{ Form::close() }}
        </div>

        <div>
<h2>Join Group</h2>
{{ Form::open(array('url' => '/Groups/join')) }}

Code:
{{ Form::text('code') }}

{{ Form::submit('Join') }}

{{ Form::close() }}
        </div>

@endsection

