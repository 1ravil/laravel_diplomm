<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('reg');
    }


    public function verify()
    {
        return view('verify');
    }

    public function store(RegisterUserRequest $request)
    {
        // сюда дойдёт только если все правила из RegisterUserRequest пройдены
        $user = User::create([
            'name'     => $request->name,
            'surname'  => $request->surname,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 1,
        ]);

        Auth::login($user);
        event(new Registered($user));          // письмо-подтверждение

        return redirect()->route('login')
            ->with('success', 'Регистрация прошла успешно!');
    }

    public function loginAuth(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->username)->first();

        if (!$user) {
            // Если пользователь не найден
            return back()->withErrors(['username' => 'Мы не нашли пользователя с таким адресом электронной почты.'])->withInput();
        }

        if (!Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            // Если пароль неверный
            return back()->withErrors(['password' => 'Неверный пароль.'])->withInput();
        }

        return redirect()->intended('/')->with('success', 'Вы успешно вошли в систему!');
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Вы вышли из системы.');
    }


    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Ваш email уже подтвержден.');
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Ссылка для подтверждения была отправлена повторно.');
    }

    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => 'Ссылка для сброса пароля отправлена!'])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Пароль успешно сброшен!')
            : back()->withErrors(['email' => __($status)]);
    }

}
