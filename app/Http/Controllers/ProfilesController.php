<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

use function PHPUnit\Framework\returnSelf;

class ProfilesController extends Controller
{
    public function index(\App\Models\User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        $time = now()->addSeconds(30);

        $postsCount = cache::remember('count.posts.'.$user->id,$time, 
        function () use($user) {
            return $user->posts->count();
        } );

        $followersCount = cache::remember('count.followers.'.$user->id, 
        $time, 
        function () use($user) {
            return $user->posts->count();
        } );
        $followingCount = cache::remember('count.following.'.$user->id, 
        $time, 
        function () use($user) {
            return $user->posts->count();
        } ); 

        
        return view('profiles.index', [
            'user'=> $user,
            'follows' => $follows,
            'postsCount' => $postsCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount, 
        ]);
    }

    public function edit (\App\Models\User $user) {

        $this->authorize('update', $user->profile);

        return view('profiles.edit' , [
            'user' => $user,
        ]);
    }

    public function update (\App\Models\User $user) {

        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);


        if(request('image')){
            $imagePath = request('image')->store('profile' , 'public');
            
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);
            $image->save();

            $arr = ['image' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $arr ?? [],
            
        ));

        return redirect("/profile/{$user->id}");
    }
}
