<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(User $user, StoreRequest $request)
    {
        $validatedData = $request->validated();

        // $comment = Comment::create($validatedData);
        $user->commentsOn()->create([
            'content' => $validatedData['content'],
            'user_id' => $request->user()->id
        ]);

        return redirect()->back()->with('status', 'Comment was added.');
    }
}