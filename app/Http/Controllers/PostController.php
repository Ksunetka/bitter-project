<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
//    public function getUserPosts($name)
//    {
//        $id = User::where('username', $name)->first()->id;
//        $posts1 = Post::whereHas('users' , function($q) use($name){
//            $q->where('username' , $name);
//        })->with('user')->get();
//        $posts2 = Post::where('user_id', $id)->with('user')->get();
//        $posts = $posts1->merge($posts2)->sortByDesc('updated_at')->values();
//        return response()->json([
//            'id' => $id,
//            'posts' => $posts,
//        ]);
//    }

    public function getAllPosts()
    {
        $allPosts = Post::orderBy('updated_at', 'DESC')->with('user')->get();
        return response()->json([
            'allPosts' => $allPosts,
        ]);
    }

    public function getPostByTag($name) {
        $posts = Post::whereHas('tags' , function($q) use($name){
            $q->where('name' , $name);
        })->with('user')->orderBy('updated_at', 'DESC')->get();
        return response()->json(['posts' => $posts]);
    }

    public function savePost(Request $request)
    {
        $post = Post::create([
            'user_id' => $request->user()->id,
            'message' => $request->message
        ]);
        $tags = $request->tags;
        $usernames = $request->usernames;
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $checkTag = Tag::where('name', $tag)->first();
                if(!$checkTag) {
                    $newTag = Tag::create(['name' => $tag]);
                    $post->tags()->attach($newTag->id);
                } else {
                    $post->tags()->attach($checkTag->id);
                }
            }
        }
        if (!empty($usernames)) {
            foreach ($usernames as $username) {
                $checkUserName = User::where('username', $username)->first();
                if($checkUserName) {
                    $post->users()->attach($checkUserName->id);
                } else {
                    return response()->json('Такого пользователя нет');
                }
            }
        }
        return response()->json($post);
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update(['message' => $request->message]);
        $tags = $request->tags;
        $usernames = $request->usernames;
        $post->tags()->detach();
        $post->users()->detach();
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $checkTag = Tag::where('name', $tag)->first();
                if(!$checkTag) {
                    $newTag = Tag::create(['name' => $tag]);
                    $post->tags()->attach($newTag->id);
                } else {
                    $post->tags()->attach($checkTag->id);
                }
            }
        }
        if (!empty($usernames)) {
            foreach ($usernames as $username) {
                $checkUserName = User::where('username', $username)->first();
                if($checkUserName) {
                    $post->users()->attach($checkUserName->id);
                } else {
                    return response()->json('Такого пользователя нет');
                }
            }
        }
        return response()->json($post);
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json('success');
    }
}
