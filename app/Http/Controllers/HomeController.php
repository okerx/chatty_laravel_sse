<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $my_id = Auth::id();
//        select all users except logged in user
        $users = User::where('id', '!=', Auth::id())->get();
        foreach ($users as $user) {
            $user_id = $user->id;
            //        getting all messages for selected user
//        getting those messages which is $from = Auth::id() AND $to = $user_id OR $from = $user_id AND $to = Auth::id()
            $messages = Message::where(function ($query) use ($user_id, $my_id) {
                $query->where('from', $my_id)->where('to', $user_id);
            })->orWhere(function ($query) use ($user_id, $my_id) {
                $query->where('from', $user_id)->where('to', $my_id);
            })->get();
            if(!empty($messages[0])){
                $last_message = $messages[0]->message;
                $last_message_date = $messages[0]->created_at;
            }
            else {
                $last_message = '';
                $last_message_date = '';
            }
            $user->last_message = $last_message;
            $user->last_message_date = $last_message_date;
        }
        return view('home', ['users' => $users]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();
//        getting all messages for selected user
//        getting those messages which is $from = Auth::id() AND $to = $user_id OR $from = $user_id AND $to = Auth::id()
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->get();

        return view('messages/index', ['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();
    }

    public function messagesStream()
    {
        $my_id = Auth::id();
//       getting all messages for selected user
//       getting those messages which is $from = Auth::id() AND $to = $user_id OR $from = $user_id AND $to = Auth::id()
        $messages = Message::all();

        $last_message = json_encode([
            "from" => $messages[count($messages) - 1]->from,
            "to" => $messages[count($messages) - 1]->to,
            "message" => $messages[count($messages) - 1]->message
        ]);

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->setCallback(
            function () use ($last_message, $my_id) {
                echo "retry: 100\n\n";
                if ($last_message != session('last_message')) {
                    if (json_decode($last_message)->to == $my_id || json_decode($last_message)->from == $my_id) {
                        echo "data: $last_message\n\n";
                    }
                    // Update last message session variable
                    session(['last_message' => $last_message]);
                }
                ob_flush();
                flush();
            });
        $response->send();

    }
}
