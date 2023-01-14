<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\StoreRequest;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogPost $post)
    {
        // return new CommentResource($post->comments->first());
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPost $post, StoreRequest $request)
    {
        // $validatedData = $request->validate([
        //     'content' => 'bail|min:5|max:1000',
        // ]);

        $validatedData = $request->validated();

        // $comment = Comment::create($validatedData);
        $comment = $post->comments()->create([
            'content' => $validatedData['content'],
            'user_id' => $request->user()->id
        ]);

        event(new CommentPosted($comment));

        $when = now()->addMinutes(1);

        // Mail::to($post->user)->send(new CommentPosted($comment));

        // Mail::to($post->user)->send(new CommentPostedMarkDown($comment));

        // Mail::to($post->user)->queue(
        //     new CommentPostedMarkDown($comment)
        // );

        // NotifyUsersPostWasCommented::dispatch($comment);

        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkDown($comment)
        // );

        return redirect()->back()->with('status', 'Comment was added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}