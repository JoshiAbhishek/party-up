@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')

<?php 

$client_id = "2906e624-6097-43da-829a-5e0d6e0fcf7d";
$redirect_uri = "https://ec2-35-166-105-107.us-west-2.compute.amazonaws.com/access";
$client_secret = "d44c7d02-ddd5-46a3-a6a2-68890abbd561";

?>

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
							<a href="https://staging-api.moj.io/OAuth2/authorize?response_type=token&client_id=<?=$client_id?>&redirect_uri=<?=$redirect_uri?>"><button id="homeLoginButton">Login with Mojio</button></a>
						</footer>
					</section>

		</div>
@endsection
