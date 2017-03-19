@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
		<div id="groups">

			<div id="groupModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="groupModalTitle">Modal title</h4>
							</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-4">
									<button id="groupDeleteButton" class="btn btn-lg btn-danger">Delete</button>
								</div>
								<div class="col-md-4">
									<button id="groupCloseButton" class="btn btn-lg btn-warning">Close</button>
								</div>
								<div class="col-md-4">
									<button id="groupViewButton" class="btn btn-lg btn-success">View</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="groupListSection" class="jumbotron">
				<div class="container">
					@foreach($groups as $group)
						<div class="group">
							<a onclick="selectGroup('{!!$group!!}')" class="btn btn-default" role="button"> {{$group}} </a>
						</div>
					@endforeach
				</div>
			</div>

			
			
			<script>

				function selectGroup(g) {
					var group = g;

					$('#groupModalTitle').text(g);
					$('#groupModal').modal('show');
				}

				$("#groupDeleteButton").on("click", function() {

					$('#groupModal').modal('hide');
				});
				$("#groupCloseButton").on("click", function() {

					$('#groupModal').modal('hide');
				});
				$("#groupViewButton").on("click", function() {

					$('#groupModal').modal('hide');
				});

			</script>

		</div>
@endsection