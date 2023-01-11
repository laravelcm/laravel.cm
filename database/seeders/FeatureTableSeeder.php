<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureTableSeeder extends Seeder
{
    public function run(): void
    {
        \Feature::add('premium', false);
        \Feature::add('badge', false);
        \Feature::add('podcasts', false);
        \Feature::add('job_skills', false);
        \Feature::add('job_profile', false);
        \Feature::add('auth_login', false);
        \Feature::add('auth_social_login', false);
        \Feature::add('article_create', false);
        \Feature::add('article_update', false);
        \Feature::add('article_delete', false);
        \Feature::add('discussion_create', false);
        \Feature::add('discussion_update', false);
        \Feature::add('discussion_delete', false);
        \Feature::add('thread_create', false);
        \Feature::add('thread_update', false);
        \Feature::add('thread_delete', false);
        \Feature::add('sponsorship', false);

        \Feature::add('preview_feature', false);
    }
}
