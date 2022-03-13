@extends('layout.main')

@section('content')
  <style>
    .ratio {
      /* background-repeat: no-repeat; */
			background-size: 100% 100%;
    }
  </style>
  
  @include('layout.header')

  <div class="container">
    <div class="row flex-wrap">
      @foreach ($books as $book)
        <div class="col-xl-2 col-md-3 col-6 mt-3">
          <div class="card text-center">
            <div class="card-img-top ratio" style="--aspect-ratio: 160%; background-image: url('{{ Storage::url($book->image) }}');">
              {{-- <img src="{{ Storage::url($book->image) }}" style="width: inherit; height: inherit;"> --}}
            </div>
            {{-- <div class="card-img-top" src="{{ Storage::url($book->image) }}" style=""> --}}

            <div class="card-body">
              <h6 class="card-title text-muted">{{ $book->category->name }}</h6>
              <h6 class="card-title text-truncate">{{ $book->title }}</h6>

              <p class="card-text">
                <div class="text-warning me-2">
                  @for ($i = 0; $i < $book->rating; $i++)
                    <i class="fa fa-star"></i>
                  @endfor

                  @for ($i = 0; $i < 5 - $book->rating; $i++)
                    <i class="fa fa-star text-muted"></i>
                  @endfor
                </div>
              </p>


              <a class="btn btn-sm btn-outline-primary px-sm-5 px-4 rounded-pill" href="/book/{{ $book->id }}">View</a>
              {{-- <a class="btn btn-sm btn-danger px-sm-5 px-4 rounded-pill" href="/book/{{ $book->id }}">Delete</a> --}}
            </div>
          </div>
        </div>
      @endforeach
      {{-- @for ($i = 0; $i < 20; $i++)
        <div class="col-lg-3 col-md-4 col-6 mt-3">
          <div class="card text-center">
            <img class="card-img-top" src="https://creativebonito.com/wp-content/uploads/2018/07/book-cover-mockup-templates-cover.png">

            <div class="card-body">
              <h6 class="card-title text-muted">School</h6>
              <h6 class="card-title">Lorem, ipsum dolor.</h6>

              <p class="card-text">
                <div class="text-warning me-2">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star text-muted"></i>
                  <i class="fa fa-star text-muted"></i>
                </div>
              </p>

              <a class="btn btn-sm btn-outline-primary px-5 rounded-pill" href="#">View</a>
            </div>
          </div>
        </div>
      @endfor --}}
    </div>

    <div class="pt-3 overflow-auto">
      {{ $books->withQueryString()->links() }}
    </div>
  </div>
@endsection