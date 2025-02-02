<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyMovieNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $movies;

    public function __construct($movies)
    {
        $this->movies = $movies;
    }

    public function build()
    {
        return $this->subject('New Movies Added Today!')
                    ->view('emails.daily_movies')
                    ->with(['movies' => $this->movies]);
    }
}
