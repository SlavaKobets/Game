<?php

namespace App\Services;

use App\Models\User;
use App\Traits\Formatter;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class UsersService
{
    use Formatter;
    /**
     * @param string $name
     * @param string $phone
     * @return RedirectResponse
     */
    public function createNewUser(string $name, string $phone): RedirectResponse
    {
        try {
            $user = User::create([
                'name'  => $name,
                'phone' => $this->formatPhone($phone),
                'link'  => Str::uuid(),
                'expired_at' => Carbon::today()->addDays(7)
            ]);

            //Auth::login($user);

            return Redirect::route('game', ['uuid' => $user->link]);

        } catch (Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function regenerateLink(string $uuid): RedirectResponse
    {
        try {
            $user = User::query()->where('link', 'LIKE', $uuid)->first();

            $newUuid = Str::uuid();

            $user->update([
                'link' => $newUuid,
                'expired_at' => Carbon::today()->addDays(7)
            ]);

           return Redirect::route('game',['uuid' => $newUuid]);
        } catch (Exception $exception){
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function disableLink(string $uuid): RedirectResponse
    {
        try {
            User::query()->where('link', 'LIKE', $uuid)->update([
               'expired_at' => now()
            ]);

            return Redirect::route('register');

        } catch (Exception $exception){
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
