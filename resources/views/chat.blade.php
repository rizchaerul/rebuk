@extends('layout.main')

@section('content')
  <style>
    .profile-image {
      height: 75px;
      width: 75px;
      overflow: hidden;
    }

    .content {
      height: calc(100vh - 76px - 2rem);
    }

    body {
      /* background-color: rgb(247, 250, 255); */
    }
  </style>
  <div class="container">
    <div class="row justify-content-center mx-1">
      <div class="content col-xl-5 col-lg-6 col-md-8 d-flex flex-column bg-white rounded-3 my-3 shadow-sm overflow-hidden">
        <div class="row py-2 justify-content-center bg-dark-blue text-white">
          <div class="col d-flex flex-row align-items-center">
            <div class="profile-image rounded-circle">
              <img src="{{ Storage::url($partner->image) }}" height="100%" width="100%">
            </div>
      
            <h3 class="ms-3">{{ $partner->name }}</h3>
          </div>
        </div>
    
        <div class="row justify-content-center flex-grow-1 overflow-auto" id="chats">
          <div class="col">
            @foreach ($chats as $chat)
              @if ($chat->sender_id == auth()->user()->id)
                <div class="card p-1 bg-light w-75 ms-auto mt-3">
                  <div class="card-body text-end">
                    {{ $chat->message }}
                  </div>
                  <p class="card-text"><small class="text-muted">{{ $chat->created_at }}</small></p>
                </div>
              @else
                <div class="card bg-primary w-75 p-1 mt-3">
                  <div class="card-body d-flex align-item-center text-white">
                    {{ $chat->message }}
                  </div>
                  <p class="card-text text-end"><small class="text-white">{{ $chat->created_at }}</small></p>
                </div>
              @endif
            @endforeach
          </div>
    
          {{-- <div class="flex-grow-1 bg-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam consectetur, est velit ex tempore perspiciatis recusandae aliquid accusantium dolorum animi quasi voluptate sint debitis, labore repellat voluptas sunt. Et, enim. Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet reprehenderit commodi vero quae error nam nobis optio iusto exercitationem voluptatibus quos magnam earum, ex facere. Veniam et nisi laudantium doloremque.</div> --}}
    
          
        </div>
    
        <div class="row justify-content-center mt-3 mb-3 mx-1">
          <form class="col p-0" action="/chat/send" method="post">
            @csrf
            <input type="hidden" name ="id" value="{{ $partner->id }}"/>
    
            <div class="input-group">
              <input autocomplete="off" type="text" class="form-control form-control-lg" name="message" placeholder="Send">
              <button class="btn btn-primary btn-lg"><i class="fa fa-send"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  

  <script>
    var objDiv = document.getElementById("chats");
    objDiv.scrollTop = objDiv.scrollHeight;
  </script>
@endsection