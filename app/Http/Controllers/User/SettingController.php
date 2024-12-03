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
}
