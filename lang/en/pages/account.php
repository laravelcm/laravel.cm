<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'title' => 'Dashboard ~ @:username',
        'stats' => [
            'articles' => 'Articles',
            'discussions' => 'Discussions',
            'experience' => 'Total Experience',
            'thread_reply' => 'Total Reply',
            'thread_resolved' => 'Thread Solved',
        ],
    ],

    'account' => [
        'location' => 'Location',
        'biography' => 'Biography',
    ],

    'activities' => [
        'title' => 'Activities',
        'answer_reply' => 'replied to topic',
        'create_article' => 'wrote the article',
        'create_thread' => 'launched the topic',
        'create_discussion' => 'started the conversation',
        'latest_of' => 'Latest activities of :name',
        'empty' => 'No activity at the moment.',
        'empty_articles' => "hasn't written any articles yet",
        'empty_discussions' => 'has not yet started discussions',
        'empty_threads' => 'has not posted any topics yet',
    ],

    'settings' => [
        'password_description' => 'You must enter your current password to update your password.',
        'password_helpText' => 'Must contain at least 8 characters, with at least one capital letter, one digit and one special character.',
        'notifications_title' => 'Manage your notifications',
        'notifications_description' => 'This page lists all e-mail subscriptions for your account. For example, you may have requested to be notified by e-mail when a particular thread or discussion is updated.',
        'preferences_title' => 'Preferences',
        'preferences_description' => 'Set your preferences for the site layout',
        'subscription_title' => 'Subscription',
        'subscription_description' => 'Check and manage your subscriptions',
        'profile_title' => 'Profile',
        'profile_description' => 'Below you will find the profile information for your account.',
        'bio_description' => 'Write a few sentences about yourself.',
        'avatar_description' => 'This will be displayed on your profile.',
        'twitter_helper_text' => 'Enter your Twitter handle without the @ symbol at the top.',
        'linkedin_helper_text' => 'Enter what is in place of {your-username}',
        'personal_information_title' => 'Personal information',
        'personal_information_description' => 'Update your personal information. Your address will never be accessible to the public.',
        'unverified_mail' => 'This e-mail address is not verified.',
        'social_network_title' => 'Social networks',
        'social_network_description' => 'Let everyone know where they can find you.',

        'notification' => [
            'tip' => 'Tip:',
            'first_text' => 'Visit any forum thread and click on the',
            'subscribe' => 'Subscribe',
            'second_text' => 'in the sidebar. Once clicked, you will receive an e-mail each time a response is published.',
        ],
    ],
];
