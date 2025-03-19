<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Место для перенаправления после верификации email.
     *
     * @var string
     */
    protected $redirectTo = '/store'; // Замените на URL, на который хотите перенаправить после верификации
}
