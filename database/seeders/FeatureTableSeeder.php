<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Feature;

final class FeatureTableSeeder extends Seeder
{
    public function run(): void
    {
        Feature::add('premium', false);
        Feature::add('badges', false);
        Feature::add('podcasts', false);

        Feature::add('job_skills', false);
        Feature::add('job_profile', false);
        Feature::add('auth_login', false);
        Feature::add('auth_social_login', false);

        Feature::add('sponsorship', false);
        Feature::add('preview_feature', false);
        Feature::add('view_profile', false);
    }
}
