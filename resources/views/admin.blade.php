@extends('layout.main')

@section('content')
  @php
    $title = 'Admin Page'
  @endphp
  @include('layout.header')

  <div class="container">
    <div class="row mt-4">
      <div class="col">
        <?php $reqCount = count($requests); ?>
        {{-- <h4 class="pb-2 @if($reqCount == 0) border-bottom pb-3 @endif">Reports</h4> --}}

        @if ($reqCount == 0)
          <div class="mb-4">Empty</div>
        @endif

        @foreach ($requests as $transaction)
          <div class="border-top d-flex g-0 p-4">
            <img  src="{{ Storage::url($transaction->receiver->image) }}" alt="" height="150px">

            <div class="row flex-grow-1 ms-3">
              <div class="col-md-10 col-12">
                <h6><a class="text-decoration-none text-dark" href="/chat/{{ $transaction->receiver->id }}">{{ $transaction->receiver->name }}</a></h6>
                <h6 class="text-muted g-0 fw-normal">Date: {{ $transaction->transaction->date }}</h6>
                <h6 class="text-muted g-0 fw-normal">Information: {{ $transaction->description }}</h6>
                <h6 class="text-muted g-0 fw-normal">Sender: <a class="text-muted" href="/chat/{{ $transaction->sender->id }}">{{ $transaction->sender->name }}</a></h6>
              </div>

              @if ($transaction->receiver->banned != 'yes')
                <div class="col-md-2 col-12 d-flex align-items-md-center">
                  <form class="ms-md-auto" action="/ban" method="post">
                    @csrf
                    <input name="userId" value="{{ $transaction->receiver->id }}" hidden>
                    <button class="btn btn-outline-danger rounded-pill" type="submit">Suspend</button>
                  </form>
                </div>
              @endif
              
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection