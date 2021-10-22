<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function slack(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $client = new Client();
        $team = env('SLACK_TEAM_NAME', 'Laravel Cameroun');
        $email = $request->input('email');

        try {
            $client->request(
                'POST',
                env('SLACK_TEAM_URL') . '/api/users.admin.invite?t='
                . time() . '&email=' . $email . '&token=' . env('SLACK_API_TOKEN')
                . '&set_active=true&_attempts=1'
            );

            session()->flash('status', "Une invitation vous a été envoyé à votre courrier pour rejoindre l'espace de travail {$team}.");

            return redirect()->back();
        } catch (GuzzleException $e) {
            session()->flash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'invitation, veuillez réessayer.');

            return redirect()->back();
        }
    }
}
