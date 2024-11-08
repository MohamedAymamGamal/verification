<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\MerchantEmailVerification;
use Illuminate\Auth\Middleware\MerchantEnsureEmailIsVerified;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchant extends Authenticatable implements MustVerifyEmail
{
    public function sendEmailVerificationNotification()
    {
        $url = URl::temporarySignedRoute(
            "merchant.verification.verify",
            now()->addMinute(44),
            [
                'id'=> $this->getKey(),
                'hash'=> sha1($this->getEmailForVerification()),
            ]

        );
        $this->notify(new MerchantEnsureEmailIsVerified($url));
    }
    use HasFactory, Notifiable;
    protected $guarded = ['id'];
}
