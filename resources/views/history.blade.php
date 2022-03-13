@extends('layout.main')

@section('content')
  @php
    $title = 'History'
  @endphp
  @include('layout.header')

  <div class="container">
    <div class="row mt-4">
      <div class="col-lg-6">
        <?php $reqCount = count($transactions); ?>
        <h4 class="pb-2 @if($reqCount == 0) border-bottom pb-3 @endif">Rent</h4>

        @if ($reqCount == 0)
          <div class="mb-4">Empty</div>
        @endif

        @foreach ($transactions as $transaction)
          <div class="border-top d-flex g-0 p-4">
            <img src="{{ Storage::url($transaction->book->image) }}" alt="" height="150px">

            <div class="row flex-grow-1 ms-3">
              <div class="col-md-7 col-12">
                <h6><a class="text-decoration-none text-dark" href="/book/{{ $transaction->book->id }}">{{ $transaction->book->title }}</a></h6>
                <h6 class="text-muted g-0 fw-normal">Date: {{ $transaction->date }}</h6>
                <h6 class="text-muted g-0 fw-normal">Status: Done</h6>
                <h6 class="text-muted g-0 fw-normal">Owner: <a class="text-muted" href="/chat/{{ $transaction->owner->id }}">{{ $transaction->owner->name }}</a></h6>
              </div>
              
              
              <div class="col-md-5 col-12 d-flex align-items-md-center">
                <div class="ms-md-auto">
                  {{-- <form class="d-inline" action="" method="post">
                    @csrf
                    <input name="transaction_id" value="{{ $transaction->id }}" hidden>
                  </form> --}}
                  @if (count($transaction->report) != 1)
                    <a class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#reportModal{{ $transaction->id }}" type="submit">Report</a>
                  @endif
                  @if (count($transaction->review) != 1)
                    <a class="btn btn-primary rounded-pill mt-xxl-0 mt-lg-3" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $transaction->id }}">Review</a>
                  @endif
                </div>
              </div>

            </div>
          </div>

          <div class="modal fade" id="reviewModal{{ $transaction->id }}">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Review {{ $transaction->book->title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <div class="modal-body">
                  <form action="/review/{{ $transaction->id }}" method="post">
                    @csrf
                    <div class="mb-4">
                      <label>Rating</label>
                      <input type="number" name="rating" class="form-control" placeholder="Rating" min="1" max="5" required>
                    </div>
                    <div class="mb-4">
                      <label>Title</label>
                      <input type="text" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="mb-4">
                      <label>Description</label>
                      <textarea class="form-control" name="description" rows="3" placeholder="Description" required></textarea>
                    </div>
                    <button class="btn btn-primary w-100 btn-lg" type="submit">Send Review</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="reportModal{{ $transaction->id }}">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Report {{ $transaction->owner->name }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <div class="modal-body">
                  <form action="/report/{{ $transaction->id }}" method="post">
                    @csrf
                    <input name="receiverId" value="{{ $transaction->owner->id }}" hidden>
                    <div class="mb-4">
                      <label>Problem Description & Contact</label>
                      <textarea class="form-control" name="description" rows="3" placeholder="e.g. Buku hilang, contact saya: xxxx-xxxx-xxxx" required></textarea>
                    </div>
                    <button class="btn btn-danger w-100 btn-lg" type="submit">Send Report</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="col-lg-6">
        <?php $reqCount = count($requests); ?>
        <h4 class="pb-2 @if($reqCount == 0) border-bottom pb-3 @endif">Request</h4>

        @if ($reqCount == 0)
          <div class="mb-4">Empty</div>
        @endif

        @foreach ($requests as $transaction)
          <div class="border-top d-flex g-0 p-4">
            <img src="{{ Storage::url($transaction->book->image) }}" alt="" height="150px">

            <div class="row flex-grow-1 ms-3">
              <div class="col-md-7 col-12">
                <h6><a class="text-decoration-none text-dark" href="/book/{{ $transaction->book->id }}">{{ $transaction->book->title }}</a></h6>
                <h6 class="text-muted g-0 fw-normal">Date: {{ $transaction->date }}</h6>
                <h6 class="text-muted g-0 fw-normal">Descripton: {{ $transaction->address }}</h6>
                <h6 class="text-muted g-0 fw-normal">Customer: <a class="text-muted" href="/chat/{{ $transaction->customer->id }}">{{ $transaction->customer->name }}</a></h6>
              </div>

              <div class="col-md-5 col-12 d-flex align-items-md-center">
                {{-- <form class="ms-md-auto" action="" method="post">
                  @csrf
                  <input name="transaction_id" value="{{ $transaction->id }}" hidden>
                  <button class="btn btn-outline-danger rounded-pill" type="submit">Report</button>
                </form> --}}
                @if (count($transaction->report) != 1)
                <a class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#reportModal{{ $transaction->id }}">Report</a>
                @endif
              </div>
            </div>
          </div>

          <div class="modal fade" id="reportModal{{ $transaction->id }}">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Report {{ $transaction->owner->name }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <div class="modal-body">
                  <form action="/report/{{ $transaction->id }}" method="post">
                    @csrf
                    <input name="receiverId" value="{{ $transaction->customer->id }}" hidden>
                    <div class="mb-4">
                      <label>Problem Description & Contact</label>
                      <textarea class="form-control" name="description" rows="3" placeholder="e.g. Buku hilang, contact saya: xxxx-xxxx-xxxx" required></textarea>
                    </div>
                    <button class="btn btn-danger w-100 btn-lg" type="submit">Send Report</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection