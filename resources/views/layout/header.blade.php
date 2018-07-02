<div class="ot-header">
	<div class="ot-header-wrapper">
		<a href="/admincp/top" class="ot-header-title">House Management</a>
		<a href="/admincp/logout" class="ot-header-logout">logout</a>
		<span class="ot-header-logout">{{ Auth::user()->name  }} | </span>
	</div>
</div>
<ul class="ot-navbar">
	<div class="ot-navbar-wrapper">
		<li class="dropdown">
			<a href="/admincp/top" class="dropbtn">Top</a>
		</li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">Images</a>
			<div class="dropdown-content">
				<a class="dropdown-content-link" href="/admincp/image/new">New Image</a>
				<a class="dropdown-content-link" href="/admincp/image/list">List</a>
			</div>
		</li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">Houses</a>
			<div class="dropdown-content">
				<a class="dropdown-content-link" href="/admincp/house/new">New House</a>
				<a class="dropdown-content-link" href="/admincp/house/list">List</a>
			</div>
		</li>
		@if(Auth::user()->name == "admin")
			<li class="dropdown">
				<a href="javascript:void(0)" class="dropbtn">User</a>
				<div class="dropdown-content">
					<a class="dropdown-content-link" href="/admincp/user/new">New User</a>
					<a class="dropdown-content-link" href="/admincp/user/list">List Active</a>
					<a class="dropdown-content-link" href="/admincp/user/listRequest">List Request</a>
				</div>
			</li>
			<li class="dropdown">
				<a href="/admincp/history_request" class="dropbtn">History Request</a>
			</li>
		@else
			<li class="dropdown">
				<a href="/admincp/user/myaccount" class="dropbtn">My Account</a>
			</li>
		@endif
	</div>
</ul>
