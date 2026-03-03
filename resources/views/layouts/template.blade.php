<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('pageTitle')</title>
    @yield('headerBlock')
    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
  </head>

  <body>
    <div id="wrapper">
      <div id="left">
        <h1>Admin Panel</h1>
        <nav class="top-nav">
          <div class="nav-link">
            <a href="/">Home</a>
            <span>|</span>
          </div>

          <div class="nav-action">
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="logout-button">Logout</button>
            </form>
          </div>
        </nav>


        <!-- <div class="box">
          <h2>Category Manager</h2>
          <ul>
            <li><a href="#">Desktops</a></li>
            <li><a href="#">Laptops</a></li>
            <li><a href="#">Photocopies</a></li>
            <li><a href="#">Printers</a></li>
            <li><a href="#">Accessories</a></li>
          </ul>
        </div> -->

        <div class="box">
          <h2>Product Manager</h2>
          <ul>
            <li><a href="/">Product Listing</a></li>
            <li><a href="/create">Create Products</a></li>
          </ul>
        </div>

        <div class="box">
          <h2>Category Manager</h2>
          <ul>
            <li><a href="/categories">Category</a></li>
          </ul>
        </div>

        <div class="box">
          <h2>User Manager</h2>
          <ul>
            <li><a href="/users">User Listing</a></li>
            <li><a href="/register">Add New User</a></li>
          </ul>
        </div>
      </div>

      <div id="right">
        <div id="rightHeader">
          <div id="hamburgerMenu" aria-label="Toggle sidebar" role="button" tabindex="0">
            <div></div>
            <div></div>
            <div></div>
          </div>

          <h1>@yield('rightTitle')</h1>
        </div>

        <!-- Optional toolbar -->
        <!-- <div id="toolbar">@yield('toolbar')</div> -->

        <div id="content">@yield('content')</div>
      </div>
    </div>

    <!-- Overlay for sidebar on small screens -->
    <div id="overlaySidebar"></div>

    <script>
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const sidebar = document.getElementById('left');
    const overlay = document.getElementById('overlaySidebar');

    function openSidebar() {
      sidebar.classList.add('active');
      overlay.classList.add('active');
    }

    function closeSidebar() {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
    }

    hamburgerMenu.addEventListener('click', () => {
      if (sidebar.classList.contains('active')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && sidebar.classList.contains('active')) {
        closeSidebar();
      }
    });
    </script>
  </body>

</html>