<div class="ot-header">
	<div class="ot-header-wrapper">
		<a href="/" class="ot-header-title">House Management</a>
		<a href="/logout" class="ot-header-logout">logout</a>
		<span class="ot-header-logout">{{ Auth::user()->name  }} | </span>
	</div>
</div>
<ul class="ot-navbar">
	<div class="ot-navbar-wrapper">
		<li class="dropdown">
			<a href="/" class="dropbtn">Top</a>
		</li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">360°Images</a>
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
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">User</a>
			<div class="dropdown-content">
				<a class="dropdown-content-link" href="/admincp/user/new">New User</a>
				<a class="dropdown-content-link" href="/admincp/user/list">List</a>
			</div>
		</li>
	</div>
</ul>
