@extends('layouts.app')

@section('content')
    <style>
        .navbar {
            display: none;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid  h-100">
            <div class="row" style="height: 100vh">
                <aside class="aside col-md-4 col-lg-3 open">
                    <div class="container-fluid p-0">
                        <nav>
                            <div class="dropdown d-inline-block">
                                <button class="btn dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="thumb d-inline-block" src="https://via.placeholder.com/75" alt="">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                </div>
                            </div>
                            <h2 class="d-inline-block">Chats</h2>
                            <button class="btn float-right aside-toggler d-md-none" style="transform: rotate(180deg); color: #0084ff; font-size: 1.5em; font-weight: bolder">&#10140;</i>
                            </button>
                        </nav>
                        <div class="users-list">
                            <ul id="users">
                                @foreach($users as $user)
                                    <li class="user" id="{{$user->id}}"
                                        timestamp="{{$user->last_message_date != ''? strtotime($user->last_message_date) : 0}}">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-3 p-0 d-flex position-relative">
                                                    <img class="thumb mx-auto" src="{{$user->avatar}}"
                                                         alt="">
                                                    <span class="new-msg-label"></span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="name d-block">{{$user->name}}</span>
                                                    <span
                                                        class="message last-message d-inline">{{$user->last_message}}</span>
                                                    <span class="message d-inline float-right">
                                                        @if(time() - strtotime($user->last_message_date) > 86400)
                                                        {{$user->last_message_date != ''? date('M d', strtotime($user->last_message_date)) : ""}}
                                                        @else
                                                            {{$user->last_message_date != ''? date('h:i A', strtotime($user->last_message_date)) : ""}}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>
                <main class="main col-md-8 col-lg-9 p-0 h-100" id="messages">
                    <div class="h-100 w-100 d-flex flex-column-reverse d-md-none">
                        <div class="p-5">
                            <button class="btn btn-light float-right aside-toggler">
                                <svg width="100px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                    <g fill="#0084ff"><path d="M856.1,708.9V575h-45.2v133.9l-133.9,0v45.2l133.9,0v133.9h45.2V754.1l133.9,0v-45.2L856.1,708.9z"/><path d="M614.9,455.8c-25.1,0-45.4,20.3-45.4,45.4c0,25.1,20.3,45.4,45.4,45.4s45.4-20.3,45.4-45.4C660.3,476.1,639.9,455.8,614.9,455.8z"/><path d="M254.1,501.2c0,25.1,20.3,45.4,45.4,45.4c25.1,0,45.4-20.3,45.4-45.4c0-25.1-20.3-45.4-45.4-45.4C274.5,455.8,254.1,476.1,254.1,501.2z"/><path d="M411.8,501.2c0,25.1,20.3,45.4,45.4,45.4c25.1,0,45.4-20.3,45.4-45.4c0-25.1-20.4-45.4-45.4-45.4C432.1,455.8,411.8,476.1,411.8,501.2z"/><path d="M436.2,158.7c209.2,0,379.4,153.1,379.4,341.3c0,13.2-0.9,26.3-2.5,39.2h47.1c1.4-12.9,2.2-25.9,2.2-39.2c0-214-191.2-388.1-426.1-388.1C201.2,111.9,10,286,10,500c0,69.6,20.7,137.7,59.9,197.7l-41,180.8l178.5-51c68.3,39.7,147.2,60.6,228.8,60.6c74.2,0,144.1-17.4,204.9-47.9v-53.1c-59.1,34.3-129.5,54.2-204.9,54.2c-76.5,0-150.3-20.4-213.3-59l-8.8-5.4L91.9,811.8L120,688.2l-5.8-8.5C76.6,625.5,56.8,563.4,56.8,500C56.8,311.8,227,158.7,436.2,158.7z"/></g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <div class="mobile-overlay aside-toggler"></div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script>
    </script>
    <script>
        // $.noConflict();
        var receiver_id = '';
        var my_id = "{{ Auth::id() }}";
        var last_data = '';

        jQuery(document).ready(function () {
            if(window.location.pathname != '/home'){
                window.location.replace('/home');
            }
            let es = new EventSource('/stream');
            es.addEventListener('message', event => {
                // console.log(event.data)
                if(event.data != last_data && event.data != ""){
                    var data = JSON.parse(event.data);
                    var html = '';
                    console.log(data);
                    if(data.from == receiver_id) {
                        html =
                            " <div class='incoming_msg'>\n" +
                            "<div class='incoming-msg-img'>\n" +
                            "<img class=\"thumb\" src='https://ptetutorials.com/images/user-profile.png' alt='Avatar'></div>\n" +
                            "<div class='received-msg'>\n" +
                            "<div class='received-withd-msg'>\n" +
                            "<p>\n" +
                            data.message +
                            "</p>\n" +
                            "<span class='time-date'></span>\n" +
                            "</div>\n" +
                            "</div>\n" +
                            "</div>";
                        jQuery( '.last-message', jQuery('#' + receiver_id) ).html(data.message);

                        jQuery('.user').each(function(index, user) {
                            if(this.id == data.to || this.id == data.from) {
                                jQuery(this).detach().insertBefore(".user:first");
                            }
                        });
                    }
                    else if (data.from == my_id && data.to == receiver_id){
                        html =
                            "<div class='outgoing-msg'>\n" +
                            "<div class='sent-msg'>\n" +
                            "<p>\n" +
                            data.message +
                            "</p>\n" +
                            "<span class='time-date'>" +
                            moment().format(' h:mm A | MMMM D'); +
                            "</div>\n" +
                        "</div>"
                        jQuery( '.last-message', jQuery('#' + receiver_id) ).html(data.message);
                        jQuery('.user').each(function(index, user) {
                            if(this.id == data.to || this.id == data.from) {
                                jQuery(this).detach().insertBefore(".user:first");
                            }
                        });
                    }
                    else {
                        jQuery('.user').each(function(index, user) {
                            if(this.id == data.from) {
                                jQuery(this).detach().insertBefore(".user:first");
                                jQuery(this).addClass('notify');
                                jQuery( '.last-message', jQuery( this ) ).html(data.message);
                            }
                        });
                    }

                }
                jQuery('.msg-history').append(html);
                last_data = event.data;
            }, false);

            es.addEventListener('error', event => {
                if (event.readyState == EventSource.CLOSED) {
                    console.log('Event was closed');
                    console.log(EventSource);
                }
            }, false);


            jQuery('.aside-toggler').on('click', function() {
                jQuery('.aside').toggleClass('open');
                jQuery('.mobile-overlay').toggleClass('open');
            });
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')
                }
            })

            jQuery('.user').click(function () {
                jQuery('.aside').toggleClass('open');
                jQuery('.user').removeClass('active');
                jQuery(this).removeClass('notify');
                jQuery(this).addClass('active');

                receiver_id = jQuery(this).attr('id');

                var name = $(this).find('span.name').text();

                jQuery.ajax({
                    type: 'get',
                    url: 'message/' + receiver_id,
                    data: "",
                    cache: false,
                    success: function (data) {
                        jQuery("#messages").html(data);
                        $('#current-name').text(name);
                    },
                    complete: function () {
                        jQuery('.aside-toggler_ajax').on('click', function() {
                            jQuery('.aside').toggleClass('open');
                            jQuery('.mobile-overlay').toggleClass('open');
                        });
                        $(".msg-history").scrollTop($(".msg-history")[0].scrollHeight);
                    }
                });
            });

            jQuery(document).on('submit', '#message-form', function (e) {
                e.preventDefault();
                var message = jQuery('#message-input').val();
                if(message != '' && receiver_id != '') {
                    jQuery('#message-input').val('');

                    var datastr = 'receiver_id=' + receiver_id + '&message=' + message;
                    jQuery.ajax({
                        type: 'post',
                        url: '/message',
                        data: datastr,
                        cache: false,
                        success: function (data) {

                        },
                        error: function (jqXHR, status, error) {

                        },
                        complete: function () {

                        }
                    })
                }
            });

            // get array of elements
            var myArray = jQuery("#users li");
            var count = 0;

            // sort based on timestamp attribute
            myArray.sort(function (a, b) {

                // convert to integers from strings
                a = parseInt(jQuery(a).attr("timestamp"), 10);
                b = parseInt(jQuery(b).attr("timestamp"), 10);
                count += 2;
                // compare
                if(a > b) {
                    return -1;
                } else if(a < b) {
                    return 1;
                } else {
                    return 0;
                }
            });

            // put sorted results back on page
            jQuery("#users").append(myArray);
            // $("#calls").append(count+1);

        });

    </script>
@endsection
