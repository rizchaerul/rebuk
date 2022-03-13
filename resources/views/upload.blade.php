@extends('layout.main')

@section('content')
  <div class="container">
    <div class="mt-3 row justify-content-center">
      <div class="p-4 rounded-3 col-xxl-6 col-xl-8 col-lg-10">
        <h2>Upload Book</h2>
        <h4 class="lead text-muted mb-5">Fill out the form to upload a book</h4>

        <form action="/register" method="post" enctype="multipart/form-data">
          @csrf

          <div class="mb-4">
            <label>Title</label>
            <input type="text " name="name" class="form-control form-control-lg" placeholder="Full Name" required>
          </div>

          <div class="mb-4">
            <label>Description</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email Address" required>
          </div>

          <div class="mb-5">
            <label>Profile Picture</label>
            <input type="file" name="image" class="form-control form-control-lg">
          </div>

          <div class="row justify-content-between align-items-center">
            <div class="col-4">
              <button class="btn btn-lg btn-primary float-end" type="submit">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection