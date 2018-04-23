<div class="ot-header">
	<div class="ot-header-wrapper">
		<a href="/" class="ot-header-title">360コンテンツ管理システム</a>
		<a href="/logout" class="ot-header-logout">ログアウト</a>
		<span class="ot-header-logout"><?php echo e(Auth::user()->name); ?> |</span>
	</div>
</div>
<ul class="ot-navbar">
	<div class="ot-navbar-wrapper">
		<li class="dropdown">
			<a href="/" class="dropbtn">トップ</a>
		</li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">360画像管理</a>
			<div class="dropdown-content">
				<a class="dropdown-content-link" href="/admincp/image/new">新規登録</a>
				<a class="dropdown-content-link" href="/admincp/image/list">一覧</a>
			</div>
		</li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">コンテンツ管理</a>
			<div class="dropdown-content">
				<a class="dropdown-content-link" href="/admincp/house/new">新規作成</a>
				<a class="dropdown-content-link" href="/admincp/house/list">一覧</a>
			</div>
		</li>
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropbtn">ユーザ管理</a>
			<div class="dropdown-content">
				<a class="dropdown-content-link" href="/admincp/user/new">新規作成</a>
				<a class="dropdown-content-link" href="/admincp/user/list">一覧</a>
			</div>
		</li>
	</div>
</ul>
