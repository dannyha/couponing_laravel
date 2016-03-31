<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<title>Laravel PHP Framework</title>
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/styles/main.css" />
</head>
<body>


<div class="layout">
	@section('header')
    <div class="header clearfix">
        <h1><a href=".">NESTLE</a></h1>
        <ul>

            <li><a href="javascript:void(0);" id="setLanguage" data-language="fr">French</a></li>

            @if (Auth::check())
                <li><a href="dashboard">Admin</a></li>
                 @if(Auth::user()->role == 'administrator')
                     <li><a href="adduser">Add User</a></li>
                @endif
                <li><a href="logout">Log Out</a></li>
            @else
            <li><a href=".">Home</a></li>
            <li><a href="coupons">Coupons</a></li>
            <li><a href="admin">Admin</a></li>
            <li id="signIn"><a href="javascript:void(0);" >
                <div class="link-text">Sign In</div>
            </a></li>
            <li id="editProfile" class="hidden"><a href="javascript:void(0);" >
                <div class="link-text">Edit Profile</div>
            </a></li>
            <li id="signOut" class="hidden"><a href="javascript:void(0);" >
                <div class="link-text">Sign Out</div>
            </a></li>
            @endif

        </ul>
    </div>
    @show

    <div class="content">
    	<iframe src="{{ Request::root() }}/login" id="signInForm" class="hidden"></iframe>
        @yield('content')
    </div>

    <div class="signInForm hidden">
        <h3>My Nestle ID</h3>
        <a href="javascript:void(0);">Facebook</a>
        <a href="javascript:void(0);">Google</a>
        <div class="seperator">OR</div>
        <form>
            <input type="text" placeholder="email address" />
            <input type="text" placeholder="password" />
            <button type="submit">Login</button>
            <button type="button">Create an Account</button>
            <a href="javascript:void(0);">Need Help?</a>
        </form>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="{{ Request::root() }}/scripts/jquery.cookie.js"></script>
<script type="text/javascript" src="{{ Request::root() }}/scripts/main.js"></script>
@section('footer')

@show

</body>
</html>

