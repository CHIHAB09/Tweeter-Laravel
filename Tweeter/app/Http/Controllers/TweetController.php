<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TweetController extends Controller
{
    public function index()
    {
        //la methode with permet d appeler une relation
        $tweets= Tweet::with('user')->get();

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
    
    
    
    
    }

}
