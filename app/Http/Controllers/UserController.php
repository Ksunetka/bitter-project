<?php

namespace App\Http\Controllers;
use App\Models\Nickname;
use App\Models\Post;
use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getAuthUsers() {
        $users = User::pluck('username');
        return response()->json([
            'users' => $users,
        ]);
    }

    public function getUserProfile($name) {
        $user = User::where('username', $name)->first();
        $posts1 = Post::whereHas('users' , function($q) use($name){
            $q->where('username' , $name);
        })->with('user')->get();
        $posts2 = Post::where('user_id', $user->id)->with('user')->get();
        $posts = $posts1->merge($posts2)->sortByDesc('updated_at')->values();
        $posts_user = Post::where('user_id', $user->id)->with('user')->get();
        $count = count($posts_user);
        return response()->json([
            'user' => $user,
            'posts' => $posts,
            'count' => $count,
        ]);
    }

    public function uploadAvatar(Request $request) {
        $this->validate($request, [
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg']
        ]);
        $avatar = $request->file('avatar');
        $avatarName = $avatar->hashName();
        if ($request->user()->avatar) {
            Storage::delete('/public/img/'.$request->user()->avatar);
        }
        $avatar->storeAs('img', $avatarName, 'public');
        $request->user()->update(['avatar' => $avatarName]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'first_name' => ['required', 'regex:/^\S*$/u'],
            'last_name' => ['required', 'regex:/^\S*$/u'],
            'username' => ['required', 'regex:/^([a-z])+?(.|_)([a-z])+$/i', "unique:users,username, $user->id"],
            'email' => ['required', 'email', "unique:users,email, $user->id"],
        ]);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
        ]);
        return response()->json($user);
    }
}
