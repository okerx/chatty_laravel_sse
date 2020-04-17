<div class="container-fluid h-100 p-0">
    <nav>
        <div>
            <button class="btn d-md-none aside-toggler_ajax">&#9776;</button>
            <img class="thumb d-inline-block" src="https://via.placeholder.com/75" alt="">
            <h2 class="d-inline-block" id="current-name"></h2>
        </div>
    </nav>
    <div class="mesgs">
        <div class="msg-history">
            @foreach($messages as $message)
                {{--if message from id is equal to auth id then it's sent by logged in user--}}
                @if($message->from == Auth::id())
                    <div class='outgoing-msg'>
                        <div class='sent-msg'>
                            <p>
                                {{$message->message}}
                            </p>
                            <span class='time-date'>{{date('h:i A | M d', strtotime($message->created_at))}}</span>
                        </div>
                    </div>
                @else
                    <div class='incoming_msg'>
                        <div class='incoming-msg-img'>
                            <img class="thumb" src='https://ptetutorials.com/images/user-profile.png' alt='Avatar'></div>
                        <div class='received-msg'>
                            <div class='received-withd-msg'>
                                <p>
                                    {{$message->message}}
                                </p>
                                <span class='time-date'>{{date('h:i A | M d', strtotime($message->created_at))}}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="type-msg">
            <form id="message-form">
                <div class="row m-0">
                    <div class="col-10 col-lg-11">
                        <input id="message-input" type="text" class="form-control mx-2" placeholder="Type a message">
                    </div>
                    <div class="col-2 col-lg-1 p-0">
                        <button class="btn btn-send">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     width="24" height="24">
                                    <path fill="currentColor"
                                          d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
