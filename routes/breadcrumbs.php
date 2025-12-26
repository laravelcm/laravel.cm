<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\Tag;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail): void {
    $trail->push(__('global.navigation.home'), route('home'));
});
Breadcrumbs::for('blog', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('global.navigation.articles'), route('articles.index'));
});
Breadcrumbs::for('discussions', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('global.navigation.discussions'), route('discussions.index'));
});
Breadcrumbs::for('tag', function (BreadcrumbTrail $trail, Tag $tag): void {
    $trail->parent('blog');
    $trail->push($tag->name, route('articles.tag', $tag));
});
Breadcrumbs::for('article', function (BreadcrumbTrail $trail, Article $article): void {
    $trail->parent('blog');
    $trail->push($article->title, route('articles.show', $article));
});
