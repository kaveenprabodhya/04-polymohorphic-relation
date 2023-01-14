<?php

namespace App\Listeners;

use App\Events\BlogPostPosted;
use App\Mail\BlogPostAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminWhenBlogPostCreated
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostPosted $event)
    {
        User::thatIsAnAdmin()->get()->map(function (User $user) {
            Mail::to($user)->queue(
                new BlogPostAdded()
            );
        });
    }
}