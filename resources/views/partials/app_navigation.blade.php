<div class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
    	<div class="navbar-header">
      		<a href="../" class="navbar-brand">Sportix</a>
      		<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
      		</button>
    	</div>
    	<div class="navbar-collapse collapse" id="navbar-main">
      		<ul class="nav navbar-nav">
        		<li>
          			<a href="#">Payments & Funds</a>
        		</li>
        		<li>
          			<a href="#">Orders</a>
        		</li>
        		<li>
          			<a href="#">Members</a>
        		</li>
      		</ul>

      		<ul class="nav navbar-nav navbar-right">
                @if (auth()->check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#">My Profile</a>
                            </li>

                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif

      		</ul>
    	</div><!--/navbar-collapse-->
  	</div><!--/container-->
</div><!--/Navbar -Header -->
