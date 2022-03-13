@extends('layout.main')

@section('content')
  <style>
    .profile-image {
      height: 75px;
      width: 75px;
      overflow: hidden;
    }
  </style>

  <div class="container">
    <div class="row py-3 justify-content-center">
      <div class="col-xl-4 col-md-6 col-8">
        <img src="{{ Storage::url($book->image) }}" width="100%">
      </div>

      <div class="mx-auto col-xl-5 col-md-6 col-12 mt-md-0 mt-3 d-flex justify-content-center flex-column">
        <div class="text-warning me-2">
          @for ($i = 0; $i < $book->rating; $i++)
            <i class="fa fa-star"></i>
          @endfor

          @for ($i = 0; $i < 5 - $book->rating; $i++)
            <i class="fa fa-star text-muted"></i>
          @endfor
        </div>

        <h1>{{ $book->title }}</h1>
        <p class="text-muted">{{ $book->description }}</p>

        <h6>Price:</h6>
        <span>
          <img src="https://www.flaticon.com/svg/static/icons/svg/550/550638.svg" height="30">
          <span>10/Day</span>
        </span>
        
        @auth
          @if ($book->user_id != auth()->user()->id)
            <form class="mt-4" action="/rent/{{ $book->id }}" method="post">
              @if (session('status'))
                <div class="alert alert-danger mb-3">
                  {{ session('status') }}
                </div>
              @endif
              @csrf

              <div class="mb-3">
                <label>Pick Date</label>
                <select class="form-select form-select-lg" name="date" required>
                  @if (count($dates) == 0)
                    <option selected disabled hidden value="">Full Booked</option>
                  @else
                    <option selected disabled hidden value="">Select Date</option>
                  @endif

                  @foreach ($dates as $date)
                    <option value="{{ $date }}">{{ $date->toFormattedDateString() }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-4">
                <label>Method & Address</label>
                <textarea class="form-control" name="address" rows="3" placeholder="e.g. COD di Jl. Sudirman" required></textarea>
              </div>
              <button class="btn btn-primary w-100 btn-lg rounded-pill" type="submit">Rent</button>
            </form>

          @else
            <form class="mt-4" action="/delete/{{ $book->id }}" method="post">
              @csrf
              <button class="btn btn-danger w-100 btn-lg rounded-pill" type="submit">Delete</button>
            </form>
          @endif
        @endauth
      </div>
    </div>

    <div class="row mt-md-5 mt-2">
      <div class="col-lg-3">
        <div class="text-center p-3 rounded-3 border">
          <div class="profile-image rounded-circle overflow-hidden mx-auto">
            <img src="{{ Storage::url($book->user->image) }}" width="100%" height="100%">
          </div>
  
          <h5 class="mb-0 text-truncate">{{ $book->user->name }}</h5>
          <p class="text-muted text-truncate">{{ $book->user->email }}</p>
  
          <a class="btn btn-outline-success d-block rounded-pill" href="/chat/{{ $book->user->id }}">Chat</a>
        </div>
        
      </div>
      <div class="col-lg-9">
        @foreach ($book->reviews as $review)
          <div class="row mb-3 mt-lg-0 mt-3">
            <div class="col">
              <div class="text-warning me-2">
                @for ($i = 0; $i < $review->rating; $i++)
                  <i class="fa fa-star"></i>
                @endfor
      
                @for ($i = 0; $i < 5 - $review->rating; $i++)
                  <i class="fa fa-star text-muted"></i>
                @endfor
              </div>

              <h3>{{ $review->title }}</h3>
              <p>{{ $review->description }}</p>
              <h6 class="d-inline">{{ $review->transaction->customer->name }}</h6>
              <h6 class="fw-normal d-inline"> - Customer</h6>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="vh-100"></div>
  </div>
@endsection