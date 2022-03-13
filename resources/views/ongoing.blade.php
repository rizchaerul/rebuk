@extends('layout.main')

@section('content')
  @php
    $title = 'Ongoing Transaction'
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
                <h6 class="text-muted g-0 fw-normal">Status: {{ $transaction->status }}</h6>
                <h6 class="text-muted g-0 fw-normal">Owner: <a class="text-muted" href="/chat/{{ $transaction->owner->id }}">{{ $transaction->owner->name }}</a></h6>
              </div>
              <div class="col-md-5 col-12 d-flex align-items-md-center">
                <form class="ms-md-auto" action="/transaction/cancel" method="post">
                  @csrf
                  <input name="transaction_id" value="{{ $transaction->id }}" hidden>
                  <button class="btn btn-outline-danger rounded-pill" type="submit">Cancel</button>
                </form>
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

              @if ($transaction->status == 'Pending')
                <div class="col-md-5 col-12 d-flex align-items-md-center">
                  <div class="ms-md-auto">
                    <form class="d-inline" action="/transaction/reject" method="post">
                      @csrf
                      <input name="transaction_id" value="{{ $transaction->id }}" hidden>
                      <button class="btn btn-outline-danger rounded-pill" type="submit">Reject</button>
                    </form>

                    <form class="d-inline" action="/transaction/accept" method="post">
                      @csrf
                      <input name="transaction_id" value="{{ $transaction->id }}" hidden>
                      <button class="btn btn-primary rounded-pill mt-xxl-0 mt-lg-3" type="submit">Accept</button>
                    </form>
                  </div>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection