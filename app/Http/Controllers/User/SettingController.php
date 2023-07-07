<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Events\EmailAddressWasChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

final class SettingController extends Controller
{
    public function profile(): View
    {
        return view('user.settings.profile');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $emailAddress = $user->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => mb_strtolower($request->username),
            'bio' => trim(strip_tags((string) $request->bio)),
            'twitter_profile' => $request->twitter_profile,
            'github_profile' => $request->github_profile,
            'linkedin_profile' => $request->linkedin_profile,
            'phone_number' => $request->phone_number,
            'location' => $request->location,
            'website' => $request->website,
        ]);

        if ($request->email !== $emailAddress) {
            $user->email_verified_at = null;
            $user->save();

            event(new EmailAddressWasChanged($user));
        }

        session()->flash('status', __('Paramètres enregistrés avec succès! Si vous avez changé votre adresse e-mail, vous recevrez une adresse e-mail pour la reconfirmer.'));

        return redirect()->route('user.settings');
    }

    public function password(): View
    {
        return view('user.settings.password', [
            'sessions' => Cache::remember('login-sessions', now()->addDays(5), function () {
                return DB::table('sessions')
                    ->where('user_id', auth()->id())
                    ->orderBy('last_activity', 'desc')
                    ->limit(3)
                    ->get()
                    ->map(fn ($session) => (object) [
                        'agent' => $this->createAgent($session),
                        'ip_address' => $session->ip_address,
                        'is_current_device' => $session->id === request()->session()->getId(),
                        'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                        'location' => Location::get($session->ip_address),
                    ]);
            }),
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        Auth::user()->update(['password' => Hash::make($request->password)]); // @phpstan-ignore-line

        session()->flash('status', __('Votre mot de passe a été changé avec succès.'));

        return redirect()->back();
    }

    protected function createAgent(mixed $session): mixed
    {
        return tap(new Agent(), function ($agent) use ($session): void {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
