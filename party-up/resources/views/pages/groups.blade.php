@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
		<div id="groups">
			@foreach($groups as $group)
				<div class="group">
					<a href='/Group/1/' class="btn btn-default" role="button"> {{$group}} </a>
				</div>
			@endforeach
		</div>
@endsection

