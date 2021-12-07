<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserDetailChatResource;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ChatController extends Controller
{
    public function index()
    {
        return view('pages.chat');
    }


    public function user($query)
    {
        $field = ['id', 'name', 'email'];
        $id = Auth::user()->id;
        if ($query === 'all') {
            $users = Chat::with(['userFrom', 'userTo'])
                ->where('chat.to_user_id', $id)
                ->orWhere('chat.user_id', $id)
                ->orderBy('created_at','desc');
            $keys = [];
            foreach ($users->get() as $key => $user) {
                if ($user->userFrom->id == $id) {
                    $keys[$key] = $user->userTo->id;
                } else {
                    $keys[$key] = $user->userFrom->id;
                }
            }
            $keys = array_unique($keys);
            $users = User::whereIn('id', $keys);
            if (!empty($key)) {
                $users = $users->orderBy('created_at','desc');
            }
        } else if ($query === 'admin') {
            $users = User::whereHas('roles', function ($query) {
                        return $query->where('name', 'superadmin');
                     })->where('id', '!=', $id);
        } 
        else {
            $users = User::where(function($row) use ($query) {
                $row->where('name', 'like', "%{$query}%")->orWhere('email','like',"%{$query}%");
            })->where('id', '!=', $id);
        }
        $users = UserResource::collection($users->get($field));
        return response()->json($users);
    }

    public function message($id)
    {
        $to = [
            ['user_id', $id],
            ['to_user_id', auth()->user()->id]
        ];
        $messages = Chat::with('users')->where($to);
        $first = $messages;
        if ($first->exists()) {
            DB::table('chat')->where($to)->update(['read_at' => now()]);
        }
        $messages = $messages->orWhere([
            ['user_id', auth()->user()->id],
            ['to_user_id', $id]
        ])->get();
        $messages = MessageResource::collection($messages);
        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        $input = $request->all();
        // dd($input);
        if ($request->hasFile('image')) {
            uploadimage($request->file('image'),'chat/image/');
            $imgName = $request->file('image')->getClientOriginalName();
            public_path('chat/image/' . $imgName);
            $imgDb = asset('chat/image/' . $imgName);
            $input['image'] = URL::to($imgDb);

        }
        $message = Chat::create($input);
        event(new MessageSent($message));
        $message = new MessageResource($message);
        return response()->json($message);
    }

    public function read($id)
    {
        $to = [
            ['user_id', $id],
            ['to_user_id', auth()->user()->id]
        ];
        DB::table('chat')->where($to)->update(['read_at' => now()]);
    }

    public function getUserFrom($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return response()->json(new UserDetailChatResource($user));
    }
}
