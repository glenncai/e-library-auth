<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Fortify::registerView(function() {
            return view('auth.register');
        });

        Fortify::loginView(function() {
            return view('auth.login');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @author Glenn Cai
         * @desc Login with either email or username with Fortify
         */
        Fortify::authenticateUsing(function (Request $request) {
            // the name field is 'email'
            $user = User::where('email', $request->email)
                ->orWhere('name', $request->email)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            } else {
                $request->session()->flash('login_error', 'The email/name or password is incorrect.');
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        /**
         * @author Glenn Cai
         * @desc Limit the number of user's login action by username/email or IP
         * @todo Exceptional user login, send warning to the corresponding user's mailbox
         */
        RateLimiter::for('login', function (Request $request) {
            // If the user fails to log in more than five times, they will need to wait 5 minutes before trying again.
            return Limit::perMinutes(5, 5)->by($request->email.$request->ip())->response(function () {
                return redirect('/login')->with('login_attempt_error', 'Login exception. You may try again in 5 mintues later.');
            });
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
