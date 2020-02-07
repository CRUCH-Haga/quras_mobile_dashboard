<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>QURAS Mobile Dashboard</title>
	<link rel="manifest" href="{{ asset('/manifest.json') }}">
	<link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('/images/app-icon-192.png') }}">
	<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
	<script src="{{ asset('/js/jquery.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</head>
<body>
<section>
	<div class="navbar navbar-default">
		<div class="navbar-header">
			<a class="navbar-brand col-xs-10" href="./">
				<img style="height: 100%;" src="{{ asset('/images/logo.svg') }}">
			</a>
			<div class="col-xs-1 text-right" style="padding: 10px;">
				<ul class="nav navbar-nav visible-xs-block">
					<li><a data-toggle="collapse" data-target="#navbar-mobile"><i style="font-size:20px" class="fa fa-bars"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li class="navbar-btn dropdown language-switch visible-lg visible-md visible-sm">
					<a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">
						<i class="fas fa-globe"></i>&nbsp;
						{{ trans('common.lang.'.app()->getLocale()) }}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li class="navbar-btn"><a href="{{ asset('/lang/en') }}"><img height="16px" src="{{ asset('/images/en.png') }}" alt="">&nbsp;English</a></li>
						<li class="navbar-btn"><a href="{{ asset('/lang/jp') }}"><img height="16px" src="{{ asset('/images/jp.png') }}" alt="">&nbsp;日本語</a></li>
						<li class="navbar-btn"><a href="{{ asset('/lang/kr') }}"><img height="16px" src="{{ asset('/images/kr.png') }}" alt="">&nbsp;한국어</a></li>
						<li class="navbar-btn"><a href="{{ asset('/lang/zh') }}"><img height="16px" src="{{ asset('/images/zh.png') }}" alt="">&nbsp;中文</a></li>
					</ul>
				</li>
				@guest
				@else
				<li class="navbar-btn dropdown visible-lg visible-md visible-sm">
					<a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">
						<i class="fas fa-user"></i>&nbsp;
						{{ Auth::user()->name }}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li class="navbar-btn">
							<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="fas fa-sign-out-alt"></i>&nbsp;Logout
							</a>
						</li>
					</ul>
				</li>
				@endguest
				<li class="visible-xs-block">
					<a style="pointer-events: none;">
						<i class="fas fa-globe"></i>&nbsp;
						{{ trans('common.lang.'.app()->getLocale()) }}
						<span class="caret"></span>
					</a>
					<ul class="mobile-dropdown-menu">
						<li class="navbar-btn"><a href="{{ asset('/lang/en') }}"><img height="16px" src="{{ asset('/images/en.png') }}" alt="">&nbsp;English</a></li>
						<li class="navbar-btn"><a href="{{ asset('/lang/jp') }}"><img height="16px" src="{{ asset('/images/jp.png') }}" alt="">&nbsp;日本語</a></li>
						<li class="navbar-btn"><a href="{{ asset('/lang/kr') }}"><img height="16px" src="{{ asset('/images/kr.png') }}" alt="">&nbsp;한국어</a></li>
						<li class="navbar-btn"><a href="{{ asset('/lang/zh') }}"><img height="16px" src="{{ asset('/images/zh.png') }}" alt="">&nbsp;中文</a></li>
					
				@guest
				@else
						<li class="navbar-btn">
							{{ Auth::user()->name }}&nbsp;
							<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								Logout
							</a>
						</li>
				@endguest
					</ul>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</li>
			</ul>
		</div>
	</div>
    <section>

    @yield('content')

    </section>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<p class="wow" style="color:white">© 2020 Quras. All Rights Reserved</p>
				</div>
			</div>
		</div>
	</footer>
</section>
<script>
	if ('serviceWorker' in navigator){
		navigator.serviceWorker.register("{{ asset('/sw.js') }}").then(function(registration){
		});
	}
</script>
</body>
</html>
