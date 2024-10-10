<?php

namespace App\Models;

use App\Mail\ConfirmationEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Verification extends Model
{
    protected $fillable = ['subscriber_id', 'token'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id', 'id');
    }

    public function sendEmail()
    {
        Mail::to($this->subscriber->email)->queue(new ConfirmationEmail($this->token));
    }
}