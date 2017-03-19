@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
		<div id="groups">
			@foreach($groups as $group)
				<div class="group">
					<a href='/Group/{{$group[0]}}/' class="btn btn-default" role="button"> {{$group[1]}} </a>
				</div>
			@endforeach
		</div>

        <div>
{{ Form::open(array('url' => '/Groups/create','method' => 'GET')) }}

{{ Form::submit('+') }}

{{ Form::close() }}
        </div>
@endsection

