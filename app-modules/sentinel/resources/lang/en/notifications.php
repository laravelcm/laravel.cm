<?php

declare(strict_types=1);

return [

    'subject' => 'Issues detected in your content (:count)',
    'greeting' => 'Hello :name,',
    'intro' => "We detected **:count issue(s)** in your content that impact the site's SEO.",
    'deadline' => 'You have **:days days** to fix them. After that, the affected elements will be automatically removed.',
    'issue_line' => '- **:model** ":title" : :type',
    'action' => 'Log in to fix these issues.',

    'types' => [
        'broken_canonical' => 'unreachable canonical URL',
        'missing_https' => 'link missing https://',
        'failed_upload' => 'failed upload',
    ],

];
