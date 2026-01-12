<?php

declare(strict_types=1);

namespace App\Enums;

enum NotificationType: string
{
    case Mention = 'new_mention';

    case Reply = 'new_reply';

    case Comment = 'new_comment';

    case ArticleDeclined = 'article_declined';
}
