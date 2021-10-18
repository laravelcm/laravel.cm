<?php

namespace App\Http\Controllers\User;

use App\Events\EmailAddressWasChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function profile()
    {
        return view('user.profile');
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
            'phone_number' => $request->phone_number,
            'website' => $request->website,
        ]);

        if ($request->avatar) {
            $user->addFromMediaLibraryRequest($request->avatar)
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
}
