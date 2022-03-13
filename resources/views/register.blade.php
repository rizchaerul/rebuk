@extends('layout.main')

@section('content')
  <div class="container">
    <div class="mt-3 row justify-content-center">
      <div class="p-4 rounded-3 col-xxl-6 col-xl-8 col-lg-10">
        <h2>Welcome to Rebuk</h2>
        <h4 class="lead text-muted mb-5">Fill out the form to get started.</h4>

        <form action="/register" method="post" enctype="multipart/form-data">
          @csrf

          <div class="mb-4">
            <label>Full Name</label>
            <input type="text " name="name" class="form-control form-control-lg" placeholder="Full Name" value="{{ old('name') }}" required>
          </div>

          <div class="mb-4">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required>
            @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
          </div>

          <div class="mb-5">
            <label>Profile Picture - Not Required</label>
            <input type="file" name="image" class="form-control form-control-lg @error('image') is-invalid @enderror">
            @error('image')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="row justify-content-between align-items-center">
            <div class="col-8">
              <p class="text-muted">Already have an account? <a class="text-decoration-none" href="/login">Login</a></p>
            </div>
            
            <div class="col-4">
              <button class="btn btn-lg btn-primary float-end" type="submit">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection