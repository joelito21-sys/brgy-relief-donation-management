<?php

namespace App\Providers;

use App\Models\Donor;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Responses\EmailVerificationSentResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Config;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Customize the authentication guard for Fortify
        Config::set('auth.defaults.guard', 'donor');

        // Configure rate limiting
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email . $request->ip());
        });

        // Bind the email verification view response
        $this->app->singleton(VerifyEmailViewResponse::class, EmailVerificationSentResponse::class);

        // Configure the login view for donor
        Fortify::loginView(function () {
            return view('donor.auth.login', [
                'guard' => 'donor',
                'loginRoute' => 'donor.login',
                'registerRoute' => 'donor.register',
                'forgotPasswordRoute' => 'donor.password.request',
            ]);
        });

        // Configure the registration view for donor
        Fortify::registerView(function () {
            return view('donor.auth.register', [
                'guard' => 'donor',
                'registerRoute' => 'donor.register',
                'loginRoute' => 'donor.login',
            ]);
        });

        // Configure the password reset link request view
        Fortify::requestPasswordResetLinkView(function () {
            return view('donor.auth.forgot-password', [
                'guard' => 'donor',
                'forgotPasswordRoute' => 'donor.password.request',
            ]);
        });

        // Configure the password reset view
        Fortify::resetPasswordView(function (Request $request) {
            return view('donor.auth.reset-password', [
                'request' => $request,
                'guard' => 'donor',
                'resetPasswordRoute' => 'donor.password.update',
            ]);
        });
    }
}
