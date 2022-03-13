<!doctype html>
<html lang="en">
  <head>
    {{-- <link rel="icon" href="{{ Storage::disk('dropbox')->url('/profileImg/chaerul.rizky@binus.ac.id.jpg') }}"> --}}
    {{-- <link rel="icon" href="{{ Storage::url('/profileImg/chaerul.rizky@binus.ac.id.jpg') }}"> --}}
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/945/945170.svg">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/f98826ac31.js"></script>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">

    <style>
      body {
        /* font-family: "Open Sans"; */
      }
      .bg-dark-blue {
        background-color: rgb(33, 50, 91);
      }
  
      .bg-light-blue {
        background-color: rgb(247, 250, 255);
      }
    </style>

    <title>Rebuk</title>
  </head>
  <body>
    <nav id="navigationBar" class="navbar navbar-expand-md @if(Request::path() == 'login' || Request::path() == '/') fixed-top @else sticky-top @endif @if(Request::path() == '/') navbar-dark @else navbar-light bg-white shadow-sm @endif" id="navigationBar">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
          <!-- <img class="me-2" src="https://www.flaticon.com/svg/static/icons/svg/945/945170.svg" alt="logo" height="50"> -->
          @if(Request::path() == '/') 
          Rebuk 
          @else <div class="d-lg-none">Rebuk</div>
          @endif
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" @if(Request::path() == '/') onclick='document.getElementById("navigationBar").classList.toggle("bg-white"); document.getElementById("navigationBar").classList.toggle("navbar-dark"); document.getElementById("navigationBar").classList.toggle("navbar-light");' @endif>
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          @if(Request::path() != '/')
          <div class="navbar-nav mt-1 mt-lg-0">
            <form action="/books/search" method="get">
              <div class="input-group rounded-pill overflow-hidden shadow-sm">
                <input type="text" class="form-control border-0" placeholder="Search" name="search" value="{{ Request::get('search') }}" required>
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
          @endif

          <div class="navbar-nav ms-auto">
            <a class="nav-link @if(Request::path() == '/') active @endif" href="/">Home</a>

            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="">Categories</a>

              <div class="dropdown-menu dropdown-menu-end shadow-sm rounded-3">
                <a class="dropdown-item" href="/books">All</a>
                @foreach (App\Category::get() as $category)
                  <a class="dropdown-item" href="/books/{{ $category->id }}">{{ $category->name }}</a>
                @endforeach
              </div>
            </div>

            
          
            @guest
              <a class="nav-link me-2 @if(Request::path() == 'login') active @endif" href="/login">Login</a>
              <a class="btn btn-warning rounded-3" href="/register">Register</a>
            @endguest

            @auth
              <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href=""> {{ auth()->user()->name }} </a>

                <div class="dropdown-menu dropdown-menu-end shadow-sm rounded-3">
                  <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#topupModal" href="">
                    <img src="/dollar.png" height="30">
                    <span>{{ auth()->user()->coin }}</span>
                  </a>

                  <hr class="dropdown-divider">

                  <?php
                    $rent = App\Transaction::where('customer_id', auth()->user()->id)->where('date', '>=', Carbon\Carbon::today()->toDateString())->get();
                    $lend = App\Transaction::where('owner_id', auth()->user()->id)->where('date', '>=', Carbon\Carbon::today()->toDateString())->get();
                  ?>

                  <a class="dropdown-item" href="/ongoing">Ongoing ({{ count($rent) + count($lend) }})</a>
                  <a class="dropdown-item" href="/history">History</a>
                  <a class="dropdown-item" href="/upload">Add Book</a>
                  <a class="dropdown-item" href="/books/user/{{ auth()->user()->id }}">My Books</a>
                  <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#withdrawModal">Withdraw</a>
                  
                  @if (auth()->user()->role == 'Admin')
                  <a class="dropdown-item" href="/admin">Admin</a>
                  {{-- <form action="/admin" method="post">
                    @csrf
                    <button class="dropdown-item" type="submit">Admin</button>
                  </form> --}}
                  @endif
                  
                  
                  <hr class="dropdown-divider">

                  <form action="/logout" method="post">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button>
                  </form>
                </div>
              </div>
            @endauth
          </div>
        </div>
      </div>
    </nav>

    @yield('content')

    <div class="modal fade" id="topupModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Top Up</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <h5 class="mb-3 d-flex align-items-center"><img src="/dollar.png" height="20px">&nbsp; 10 Coins <form class="ms-auto" action="/topup/10" method="post">@csrf <button type="submit" class="btn btn-sm btn-primary" href="">Rp. 10.000,00</button></form></h5>
            <h5 class="mb-3 d-flex align-items-center"><img src="/dollar.png" height="20px">&nbsp; 20 Coins <form class="ms-auto" action="/topup/20" method="post">@csrf <button type="submit" class="btn btn-sm btn-primary" href="">Rp. 15.000,00</button></form></h5>
            <h5 class="mb-3 d-flex align-items-center"><img src="/dollar.png" height="20px">&nbsp; 40 Coins <form class="ms-auto" action="/topup/40" method="post">@csrf <button type="submit" class="btn btn-sm btn-primary" href="">Rp. 35.000,00</button></form></h5>
            <h5 class="mb-3 d-flex align-items-center"><img src="/dollar.png" height="20px">&nbsp; 80 Coins <form class="ms-auto" action="/topup/80" method="post">@csrf <button type="submit" class="btn btn-sm btn-primary" href="">Rp. 75.000,00</button></form></h5>
          </div>
        </div>
      </div>
    </div>

    @auth
      <div class="modal fade" id="withdrawModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Withdraw</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="/withdraw" method="post">
              <div class="modal-body">
              
                @csrf

                <div class="mb-4">
                  <label>Amount</label>
                  <?php
                    if(auth()->user()->coin <= 50) {
                      $max = 0;
                    }
                    else $max = auth()->user()->coin - 50;
                  ?>
                  <input type="number" name="amount" class="form-control" placeholder="Amount" min="0" max="{{ $max }}" required>
                </div>

                <div class="mb-4">
                  <label>No. Rekening</label>
                  <input type="number" class="form-control" placeholder="No. Rekening" required>
                </div>
                
                <div class="mb-3">
                  <label>Bank</label>
                  <select class="form-select">
                    <option>Bank One</option>
                    <option>Bank Two</option>
                    <option>Bank Three</option>
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary float-end">Withdraw</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endauth
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
