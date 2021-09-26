<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Fortify;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon;

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
         * @desc Login only by username in order to prevent user's email expose to the attacker
         */
        Fortify::authenticateUsing(function (Request $request) {
            // the name field is 'email'
            $user = User::where('name', $request->name)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            } else {
                $request->session()->flash('login_error', 
                'The username or password is incorrect.');
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        /**
         * @author Glenn Cai
         * @desc Limit the number of user's login action by username and IP
         */
        RateLimiter::for('login', function (Request $request) {
            // If the user fails to log in more than five times, they will need to wait 5 minutes before trying again.
            return Limit::perMinutes(5, 5)->by($request->name.$request->ip())->response(function (Request $request) {
                // Find the corresponding email by name, name is unique
                $email = DB::select('select email from users where name = ?', [$request->name]);

                // Get the user details who are trying to login
                $ip = trim(file_get_contents('https://api.ipify.org'));
                $userDetails = Location::get($ip);

                // Get the user login action time
                $userLoginTime = Carbon::now('Asia/Hong_Kong');
                $currentTime = $userLoginTime->toDateTimeString();

                $details = [
                    'title' => '辰光閣文庫',
                    'name' => $request->name,
                    'body' => 'Your account has frequently failed to log in recently, please confirm whether it is your own operation. If not, please change the password immediately.',
                    'member' => 'Glenn Cai',
                    'team' => 'Support Team',
                    'ip' => $userDetails->ip,
                    'countryName' => $userDetails->countryName,
                    'regionName' => $userDetails->regionName,
                    'currentTime' => $currentTime,
                ];
            
                Mail::to($email)->send(new \App\Mail\sendMail($details));
                return redirect('/login')->with('login_attempt_error', 'Login exception. You may try again in 5 mintues later.');
            });
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
