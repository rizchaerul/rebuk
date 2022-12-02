@extends('layout.main')

@section('content')
  <style>
    .cover {
      background-image: url('https://i.pinimg.com/originals/4a/94/26/4a94268541d7a0ed95a8be5138e8a288.jpg');
      /* background-image: url('https://cdn.hipwallpaper.com/i/67/14/JnPeos.jpg'); */
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }

    #navigationBar {
      transition: 500ms;
    }
  </style>

  <div class="cover text-white">
    <div class="container">
      <div class="row vh-100 align-items-center">
        <div class="col-lg-6">
          <h1 class="display-3"><strong>Pinjam buku dan dapatkan ilmunya.</strong></h1>
          <p class="lead fs-5 mb-5">Dapatkan pengalaman dalam kemudahan meminjam buku sesuai yang anda inginkan dengan harga yang murah.</p>

          <form action="/books/search" method="get">
            <div class="input-group">
              <input type="text" class="form-control form-control-lg" placeholder="Search" name="search" required>
              <button class="btn btn-primary btn-lg"><i class="fa fa-search"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
