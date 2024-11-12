<?php

declare(strict_types=1);

return [

    'article' => [
        'created' => 'Your article has been created.',
        'submitted' => 'Thank you for submitting your article. We will only contact you once we have accepted your article.',
        'updated' => 'Your article has been updated.',
    ],

    'thread' => [
        'created' => 'Thread was successfully created.',
        'updated' => 'Thread was successfully updated.',
        'deleted' => 'Thread was successfully deleted.',
        'best_reply' => 'You have accepted this solution as the best answer for this thread.',
        'subscribe' => 'You are now subscribed to this thread.',
        'unsubscribe' => 'You have unsubscribed from this thread.',
    ],

    'exceptions' => [
        'unverified_user' => 'You are not authorized to do this. Your e-mail is not verified',
    ],

    'reply' => [
        'created' => 'Answer successfully added.',
        'updated' => 'Successfully updated answer.',
    ],

    'error' => 'Oops! You\'ve got errors.',

    'user' => [
        'banned' => [
            'title' => 'The user has been banned.',
            'body' => 'The user has been notified that he has been banned'
        ],
        'unbanned' => [
            'title' => 'The user has been un-banned',
            'body' => 'The user has been notified that he can log in again.'
        ],
        'cannot' => [
            'title' => 'Unable to ban',
            'body' => 'This user is already banned.',
            'ban_admin' => 'You cannot ban an administrator.',
        ]
    ]
];