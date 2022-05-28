<?php

namespace App\Http\Controllers\User;

use App\Events\EmailAddressWasChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class SettingController extends Controller
{
    public function profile()
    {
        return view('user.settings.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $emailAddress = $user->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => strtolower($request->username),
            'bio' => trim(strip_tags($request->bio)),
            'twitter_profile' => $request->twitter_profile,
            'github_profile' => $request->github_profile,
            'linkedin_profile' => $request->linkedin_profile,
            'phone_number' => $request->phone_number,
            'location' => $request->location,
            'website' => $request->website,
        ]);

        if ($request->avatar) {
            $user->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
            $user->avatar_type = 'storage';
            $user->save();
        }

        if ($request->email !== $emailAddress) {
            $user->email_verified_at = null;
            $user->save();

            event(new EmailAddressWasChanged($user));
        }

        session()->flash('status', 'Paramètres enregistrés avec succès! Si vous avez changé votre adresse e-mail, vous recevrez une adresse e-mail pour la reconfirmer.');

        return redirect()->route('user.settings');
    }

    public function password()
    {
        return view('user.settings.password', [
            'sessions' => Cache::remember('login-sessions', 60 * 60 * 24 * 5, function () {
                return collect(
                    DB::table('sessions')
                        ->where('user_id', auth()->id())
                        ->orderBy('last_activity', 'desc')
                        ->limit(3)
                        ->get()
                )->map(function ($session) {
                    return (object) [
                        'agent' => $this->createAgent($session),
                        'ip_address' => $session->ip_address,
                        'is_current_device' => $session->id === request()->session()->getId(),
                        'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                        'location' => Location::get($session->ip_address),
                    ];
                });
            }),
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        Auth::user()->update(['password' => Hash::make($request->password)]);

        session()->flash('status', 'Votre mot de passe a été changé avec succès.');

        return redirect()->back();
    }

    protected function createAgent($session)
    {
        return tap(new Agent(), function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
