<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Thread;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles = Cache::remember('latestArticles', now()->addHour(), function () {
            return Article::with('tags')
                ->orderByDesc('sponsored_at')
                ->orderByDesc('submitted_at')
                ->orderByViews()
                ->published()
                ->trending()
                ->limit(4)
                ->get();
        });

        $latestThreads = Cache::remember('latestThreads', now()->addHour(), function () {
            return Thread::whereNull('solution_reply_id')
                ->whereBetween('threads.created_at', [now()->subMonth(), now()])
                ->inRandomOrder()
                ->limit(4)
                ->get();
        });

        $latestDiscussions = Cache::remember('latestDiscussions', now()->addDay(), function () {
            return Discussion::query()
                ->scopes('popular')
                ->orderByViews()
                ->limit(3)
                ->get();
        });

        seo()
            ->description('Laravel Cameroun est le portail de la communauté de développeurs PHP & Laravel au Cameroun, On partage, on apprend, on découvre et on construit une grande communauté.')
            ->twitterDescription('Laravel Cameroun est le portail de la communauté de développeurs PHP & Laravel au Cameroun, On partage, on apprend, on découvre et on construit une grande communauté.')
            ->withUrl();

        return view('home', compact('latestArticles', 'latestThreads', 'latestDiscussions'));
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
                env('SLACK_TEAM_URL').'/api/users.admin.invite?t='
                .time().'&email='.$email.'&token='.env('SLACK_API_TOKEN')
                .'&set_active=true&_attempts=1'
            );

            session()->flash('status', "Une invitation vous a été envoyé à votre courrier pour rejoindre l'espace de travail {$team}.");

            return redirect()->back();
        } catch (GuzzleException $e) {
            session()->flash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'invitation, veuillez réessayer.');

            return redirect()->back();
        }
    }
}
