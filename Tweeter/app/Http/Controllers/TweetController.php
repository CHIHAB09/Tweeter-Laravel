<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TweetController extends Controller
{
    public function index()
    {
        //la methode with permet d appeler une relation
            $tweets= Tweet::with([
                'user' => fn ($query) => $query->withCount([
                    'followers as is_followed' => fn ($query) 
                    => $query->where('follower_id', auth()->user()->id)
                ])
                ->withCasts([
                    'is_followed' => 'boolean'
                ])

            ])
            ->orderBy('created_at','DESC')
            ->get();


        return Inertia::render('Tweets/Index', [
            'tweets' => $tweets
        ]);
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required','max:280'],
            'user_id' => ['exists:users,id']
        ]);
    
        Tweet::create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id
        ]);
            
        return Redirect::route('tweets.index');
    }

    public function followings()
    {

        $followings = Tweet::with('user')
        ->whereIn('user_id', auth()->user()->followings->pluck('id'))
        ->orderBy('created_at','DESC')
        ->get();

        return Inertia::render('Tweets/Followings', [
            'followings' => $followings
        ]); 

    }

    public function profile(User $user)
    {
        $profileUser = $user->loadCount([
            'followings as is_following_you' => fn ($query)
            => $query->where('following_id',auth()->user()->id)
            ->withCasts(['is_following_you' => 'booleann']),
            'followers as is_followed' =>
                fn ($query) => $query->where('follower_id',auth()->user()->id)
                ->withCasts(['is_followed' => 'booleann'])

        ]);

        
        $tweets = $user->tweets;

        return Inertia::render('Tweets/Profile',[
            'profileUser' => $profileUser,
            'tweets' => $tweets
        ]);
    }

    //ajout a la db

    public function follows(User $user)
    {
        auth()->user()->followings()->attach($user->id);
        return Redirect::route('tweets.index');
    }
    //suppression a la db
    public function unfollows(User $user)
    {
        auth()->user()->followings()->detach($user->id);
        /* return Redirect::route('tweets.index'); */
        // si jamais on veut rester su la page abonnement et pas etre rediriger vers l apage tweet
        return Redirect()->back();
    }
}
