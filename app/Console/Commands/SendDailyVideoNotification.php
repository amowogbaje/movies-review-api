<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Movie;
use App\Mail\DailyMovieNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyVideoNotification extends Command
{
    protected $signature = 'videos:notify-users';
    protected $description = 'Send a daily email to users about newly added videos';

    public function handle()
    {
        // Get videos added in the last 24 hours
        $videos = Movie::where('created_at', '>=', Carbon::yesterday())->get();

        if ($videos->isEmpty()) {
            $this->info('No new videos added in the last 24 hours.');
            return;
        }

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new DailyMovieNotification($videos));
        }

        $this->info('Daily video notifications sent successfully.');
    }
}
