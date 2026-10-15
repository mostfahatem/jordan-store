<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Authenticate admin user.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            if (! $user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'هذا الحساب ليس لديه صلاحيات المسؤول للوصول للوحة التحكم.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'))->with('success', 'مرحباً بك مجدداً في لوحة تحكم متجر جوردان!');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة. يرجى التحقق من البريد أو كلمة المرور.',
        ])->onlyInput('email');
    }

    /**
     * Log out admin user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج بنجاح.');
    }

    /**
     * 1-Click Demo Login for prospective buyers and evaluators.
     */
    public function demoLogin(Request $request): RedirectResponse
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@jordan.com'],
            [
                'name' => 'Jordan Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        if (! $admin->is_admin) {
            $admin->update(['is_admin' => true]);
        }

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', '🚀 تم الدخول السريع في وضع تجربة المسؤول (Live Demo Mode)! استمتع باستكشاف لوحة التحكم والأوردرات.');
    }
}
