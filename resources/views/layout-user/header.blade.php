<header>
    <nav class="navbar navbar-inverse" id="main-menu">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <img src="images/logo-cong-thong-tin-bds.png" alt=""> -->
            </a>
            <div class="navbar-header pull-right">
                <a class="phone-number" href="tel:0922 11 39 30">
                    <i class="icon ion-ios-telephone-outline"></i> <span>0908 41 64 84</span>
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                </button>
            </div>
            <div class="collapse navbar-collapse pull-right" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li class="{{ Request::is('/') ? 'active' : '' }}">
                        <a href="/">Home</a>
                    </li>
                    <li class="{{ Request::is('all') ? 'active' : '' }}">
                        <a href="/all">Rent</a>
                    </li>
                    <li class="{{ Request::is('wishlist') ? 'active' : '' }}">
                        <a href="/wishlist">Wishlist</a>
                    </li>
                    <li class="{{ Request::is('contact') ? 'active' : '' }}">
                        <a href="/contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>