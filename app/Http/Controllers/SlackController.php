<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class SlackController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $client = new Client();
        $team = config('lcm.slack.team');
        $email = $request->input('email');

        try {
            $client->request(
                'POST',
                config('lcm.slack.url').'/api/users.admin.invite?t='
                .time().'&email='.$email.'&token='.config('lcm.slack.token')
                .'&set_active=true&_attempts=1'
            );

            session()->flash('status', __('Une invitation vous a été envoyé à votre courrier pour rejoindre l\'espace de travail :team.', ['team' => $team]));

            return redirect()->back();
        } catch (GuzzleException $e) {
            session()->flash('error', __("Une erreur s'est produite lors de l'envoi de l'invitation, veuillez réessayer."));

            return redirect()->back();
        }
    }
}
