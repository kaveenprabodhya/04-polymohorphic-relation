<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use App\Services\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private $counter;

    public function __construct(Counter $counter)
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->counter = $counter;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\App\Models\BlogPost::all());
        // $posts = BlogPost::withCount('comments')->get();

        // $mostCommented = Cache::remember('most-commented-blog-posts', now()->addSeconds(10), function () {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });

        // $mostActive = Cache::remember('users-most-active', now()->addSeconds(10), function () {
        //     return User::withMostBlogPosts()->take(5)->get();
        // });

        // $mostActiveLastMonth = Cache::remember('users-most-active-last-month', now()->addSeconds(10), function () {
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();
        // });

        // return view('posts.index', [
        //     'posts' => BlogPost::latest()->withCount('comments')
        //         // ->orderBy('created_at', 'desc')
        //         ->with('user')
        //         ->get(),
        //     'mostCommented' => BlogPost::mostCommented()->take(5)->get(),
        //     'mostActive' => User::withMostBlogPosts()->take(5)->get(),
        //     'mostActiveLastMonth' => User::withMostBlogPostsLastMonth()->take(5)->get(),
        // ]);

        return view('posts.index', [
            // 'posts' => BlogPost::latest()->withCount('comments')
            //     ->with(['user', 'tags'])
            //     ->get(),
            'posts' => BlogPost::withLatestRelations()->get()
            // 'mostCommented' => $mostCommented,
            // 'mostActive' => $mostActive,
            // 'mostActiveLastMonth' => $mostActiveLastMonth,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        // $validatedData = $request->validate([
        //     // bail means only stop checking or following chain when the first rule which is failed
        //     'title' => 'bail|required|min:5|max:100',
        //     'content' => 'required|max:255',
        // ]);

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $post = BlogPost::create($validatedData);
        // $post->title = $request->input('title');
        // $post->title = $validatedData['title'];
        // $post->content = $request->input('content');
        // $post->content = $validatedData['content'];
        // $post->save();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            // $file->store('thumbnails');

            // dump($file->store('thumbnails'));
            // dump(Storage::disk('public')->put('thumbnails', $file));

            // $fileName = $post->id . '-' . $post->title . '.' . $file->guessExtension();

            // dump($file->storeAs('images', $fileName, 'local'));

            // $name = dump($file->storeAs('thumbnails', $post->id . '-' . $post->title . '.' . $file->guessExtension()));
            // dump(Storage::putFileAs('thumbnails', $file, $post->id . '-' . $post->title . '.' . $file->guessExtension()));
            // dump(Storage::url($name));

            $post->image()->save(
                Image::make([
                    'path' => $path
                ])
            );
        }
        // die();

        event(new BlogPostPosted($post));

        // return redirect('/posts');
        $request->session()->flash('success', 'Post was created.');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $post = BlogPost::findOrFail($id);

        // $post = BlogPost::with('comments')->findOrFail($id);

        // $post = BlogPost::with(['comments' => function ($query) {
        //     return $query->latest();
        // }])->findOrFail($id);

        // dd(BlogPost::with(['comments', 'user'])->findOrFail($id));

        // $sessionId = session()->getId();
        // $counterKey = "blog-post-{$id}-counter";
        // $usersKey = "blog-post-{$id}-users";

        // $users = Cache::get($usersKey, []);
        // $usersUpdate = [];
        // $difference = 0;

        // foreach ($users as $session => $lastVisit) {
        //     if (now()->diffInMinutes($lastVisit) >= 1) {
        //         $difference--;
        //     } else {
        //         $usersUpdate[$session] = $lastVisit;
        //     }
        // }

        // if (!array_key_exists($sessionId, $users) || now()->diffInMinutes($users[$sessionId]) >= 1) {
        //     $difference++;
        // }

        // $usersUpdate[$sessionId] = now();
        // Cache::forever($usersKey, $usersUpdate);

        // if (!Cache::has($counterKey)) {
        //     Cache::forever($counterKey, 1);
        // } else {
        //     cache::increment($counterKey, $difference);
        // }

        // $counter = Cache::get($counterKey);

        $counter = resolve(Counter::class);

        $blogPost = Cache::remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments')
                ->with('user')
                ->with('tags')
                ->with('comments.user')
                ->findOrFail($id);
        });

        return view('posts.show', ['post' => $blogPost, 'counter' => $this->counter->increment("blog-post-{$id}")]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You cant edit this blog post.");
        // }
        // if (Gate::denies('posts.update', $post)) {
        //     abort(403, "You cant edit this blog post.");
        // }
        // if (Gate::denies('update', $post)) {
        //     abort(403, "You cant edit this blog post.");
        // }

        $this->authorize($post);

        $validatedData = $request->validated();
        $post->fill($validatedData);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make([
                        'path' => $path
                    ])
                );
            }

            // $post->image()->save(
            //     Image::create([
            //         'path' => $path
            //     ])
            // );
        }

        $post->save();
        $request->session()->flash('success', 'Post was updated.');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // dd('destroy');
        $post = BlogPost::findOrFail($id);
        // $post = BlogPost::destroy($id);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You cant delete this blog post.");
        // }

        // $this->authorize('delete-post', $post);
        // $this->authorize('posts.delete', $post);
        // $this->authorize('delete', $post);
        $this->authorize($post);

        $post->delete();

        $request->session()->flash('success', 'Post was deleted.');
        return redirect()->route('posts.index');
    }
}