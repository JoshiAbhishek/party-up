@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
		<div id="home">

			<!--

			<div id="homeTopSection" class="jumbotron">
				<div class="container">
					<h1> Party Up </h1>
				</div>
			</div>

			<div id="homeAboutSection" class="jumbotron">
				<div class="container">
					<h2>About Us</h2>
				</div>
			</div>

			<div id="homeJoinSection" class="jumbotron">
				<div class="container">
					<h2>Join Today</h2>

					<a href="/Groups" class="btn btn-default" role="button">Login with Mojio</a>
				</div>
			</div>

			-->

			<!-- Main -->
					<section id="main">
						<header>
							<span class="avatar"><img src="http://arwenevecom.ipage.com/Flight/Images/Compass.gif" alt="" /></span>
							<h1>PARTY UP</h1>
							<p>Live Life Multiplayer</p>
						</header>
						<footer>
							<!--
							<ul class="icons">
								<li><a href="#" class="fa-twitter">Twitter</a></li>
								<li><a href="#" class="fa-instagram">Instagram</a></li>
								<li><a href="#" class="fa-facebook">Facebook</a></li>
							</ul>
							-->
							<button id="homeLoginButton">Login with Mojio</button>
						</footer>
					</section>

					<script>
						$("#homeLoginButton").on("click", function(){
							window.location.href = "/Groups";
						});
						$("#homeRegisterButton").on("click", function(){
							window.location.href = "/Groups";
						});
					</script>
		</div>
@endsection
