<x-app-layout title="{{ __('pages/faq.title') }}">
    <x-container class="py-10">
        <div class="mb-14">
            <h2 class="font-heading text-3xl font-extrabold text-gray-900 lg:text-4xl">{{ __('pages/faq.title') }} 🤔</h2>
            <p class="mt-2 text-sm font-normal text-gray-400 dark:text-gray-500 lg:text-base">
                {{ __('pages/faq.description').'' }}
            </p>
        </div>

        <div id="faq-questions" class="-mx-2 -mt-4 flex text-base">
            <div class="w-full flex-none space-y-4 px-2 md:hidden">
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.one.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.one.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.one.second_description') }}
                            <a href="{{ route('rules') }}"> {{  __('pages/faq.rules') }}</a>
                            .
                        </p>
                        <p>
                            {{  __('pages/faq.card.one.tirdh_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.two.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.two.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.two.second_description') }}
                            <a href="{{ route('rules') }}"> {{  __('pages/faq.rules') }}</a>
                            .
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.three.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.three.sub_description') }}
                        </p>
                        <p>
                           {{  __('pages/faq.card.three.first_description') }}
                            <a href="{{ route('slack') }}">Slack</a>
                            {{  __('pages/faq.card.three.second_description') }}
                            <a href="{{ route('slack') }}">page</a>
                            .
                        </p>
                        <p>
                            {{  __('pages/faq.card.three.third_paragraph_part_one') }}
                            <a href="https://t.me/laravelcameroun">Telegram</a>
                            {{  __('pages/faq.card.three.third_paragraph_part_two') }}
                        </p>
                        <p>{{  __('pages/faq.card.three.four_paragraph') }}</p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.four.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.four.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.four.second_description_part_one') }}
                            <a href="{{ route('sponsors') }}">Sponsoring</a>
                            {{  __('pages/faq.card.four.second_description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                           {{  __('pages/faq.card.twelve.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                              {{  __('pages/faq.card.twelve.first_description') }}
                        </p>
                        <p>   {{  __('pages/faq.card.twelve.second_description') }}</p>
                        <p>
                               {{  __('pages/faq.card.twelve.thrid_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.fourteen.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.fourteen.first_description') }}
                            <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                            {{  __('pages/faq.card.fourteen.second_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">{{  __('pages/faq.card.fifteen.title') }}</h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.fifteen.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.fifteen.second_description_part_one') }}
                            <a href="#">{{  __('pages/faq.card.fifteen.become_premium') }}</a>
                            {{  __('pages/faq.card.fifteen.second_description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.height.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.height.description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.nine.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.nine.first_description_part_one') }}
                            <a href="https://tallstack.dev" target="_blank">TALL Stack</a>
                            {{  __('pages/faq.card.nine.first_description_part_two') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.nine.second_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.ten.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.ten.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.ten.second_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.ten.third_description') }}
                            <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.eleven.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.eleven.description_part_one') }}
                            <a href="{{ config('app.url') }}/feed">{{ config('app.url') }}/feed</a>
                            {{  __('pages/faq.card.eleven.description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.thirteen.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.thirteen.description_one') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.thirteen.description_part_two') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden w-1/2 flex-none space-y-4 px-2 md:block lg:hidden">
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.two.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.two.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.two.second_description') }}
                            <a href="{{ route('rules') }}"> {{  __('pages/faq.rules') }}</a>
                            .
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.three.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>

                        </p>
                        <p>
                           {{  __('pages/faq.card.three.first_description') }}
                            <a href="{{ route('slack') }}">Slack</a>
                            {{  __('pages/faq.card.three.second_description') }}
                            <a href="{{ route('slack') }}">page</a>
                            .
                        </p>
                        <p>
                            {{  __('pages/faq.card.three.third_paragraph_part_one') }}
                            <a href="https://t.me/laravelcameroun">Telegram</a>
                            {{  __('pages/faq.card.three.third_paragraph_part_two') }}
                        </p>
                        <p>{{  __('pages/faq.card.three.four_paragraph') }}</p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.four.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.four.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.four.second_description_part_one') }}
                            <a href="{{ route('sponsors') }}">Sponsoring</a>
                            {{  __('pages/faq.card.four.second_description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                           {{  __('pages/faq.card.twelve.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                              {{  __('pages/faq.card.twelve.first_description') }}
                        </p>
                        <p>   {{  __('pages/faq.card.twelve.second_description') }}</p>
                        <p>
                               {{  __('pages/faq.card.twelve.thrid_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.fourteen.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.fourteen.first_description') }}
                            <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                            {{  __('pages/faq.card.fourteen.second_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">{{  __('pages/faq.card.fifteen.title') }}</h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.fifteen.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.fifteen.second_description_part_one') }}
                            <a href="#">{{  __('pages/faq.card.fifteen.become_premium') }}</a>
                            {{  __('pages/faq.card.fifteen.second_description_part_two') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden w-1/2 flex-none space-y-4 px-2 md:block lg:hidden">
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.one.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.one.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.one.second_description') }}
                            <a href="{{ route('rules') }}"> {{  __('pages/faq.rules') }}</a>
                            .
                        </p>
                        <p>
                            {{  __('pages/faq.card.one.tirdh_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.height.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.height.description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.nine.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.nine.first_description_part_one') }}
                            <a href="https://tallstack.dev" target="_blank">TALL Stack</a>
                            {{  __('pages/faq.card.nine.first_description_part_two') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.nine.second_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">  {{  __('pages/faq.card.ten.title') }} </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.ten.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.ten.second_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.ten.third_description') }}
                            <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.eleven.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.eleven.description_part_one') }}
                            <a href="{{ config('app.url') }}/feed">{{ config('app.url') }}/feed</a>
                            {{  __('pages/faq.card.eleven.description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.thirteen.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.thirteen.description_one') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.thirteen.description_part_two') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden w-1/3 flex-none space-y-4 px-2 lg:block">
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.two.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.two.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.two.second_description') }}
                            <a href="{{ route('rules') }}"> {{  __('pages/faq.rules') }} </a>
                            .
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.three.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.three.sub_description') }}
                        </p>
                        <p>
                           {{  __('pages/faq.card.three.first_description') }}
                            <a href="{{ route('slack') }}">Slack</a>
                            {{  __('pages/faq.card.three.second_description') }}
                            <a href="{{ route('slack') }}">page</a>
                            .
                        </p>
                        <p>
                            {{  __('pages/faq.card.three.third_paragraph_part_one') }}
                            <a href="https://t.me/laravelcameroun">Telegram</a>
                            {{  __('pages/faq.card.three.third_paragraph_part_two') }}
                        </p>
                        <p> {{  __('pages/faq.card.three.four_paragraph') }}</p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.four.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.four.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.four.second_description_part_one') }}
                            <a href="{{ route('sponsors') }}">Sponsoring</a>
                            {{  __('pages/faq.card.four.second_description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                           {{  __('pages/faq.card.twelve.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                              {{  __('pages/faq.card.twelve.first_description') }}
                        </p>
                        <p>   {{  __('pages/faq.card.twelve.second_description') }}</p>
                        <p>
                               {{  __('pages/faq.card.twelve.thrid_description') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden w-1/3 flex-none space-y-4 px-2 lg:block">
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.fourteen.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.fourteen.first_description') }}
                            <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                            {{  __('pages/faq.card.fourteen.second_description') }}

                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">{{  __('pages/faq.card.fifteen.title') }}</h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.fifteen.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.fifteen.second_description_part_one') }}
                            <a href="#">{{  __('pages/faq.card.fifteen.become_premium') }}</a>
                            {{  __('pages/faq.card.fifteen.second_description_part_two') }}
                        </p>
                    </div>
                </div>
                 <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.height.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.height.description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.nine.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.nine.first_description_part_one') }}
                            <a href="https://tallstack.dev" target="_blank">TALL Stack</a>
                            {{  __('pages/faq.card.nine.first_description_part_two') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.nine.second_description') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden w-1/3 flex-none space-y-4 px-2 lg:block">
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.one.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.one.first_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.one.second_description') }}
                            <a href="{{ route('rules') }}"> {{  __('pages/faq.rules') }}</a>
                            .
                        </p>
                        <p>
                            {{  __('pages/faq.card.one.tirdh_description') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900"> {{  __('pages/faq.card.ten.title') }} </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.ten.second_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.ten.second_description') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.ten.third_description') }}
                            <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.eleven.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.eleven.description_part_one') }}
                            <a href="{{ config('app.url') }}/feed">{{ config('app.url') }}/feed</a>
                            {{  __('pages/faq.card.eleven.description_part_two') }}
                        </p>
                    </div>
                </div>
                <div class="rounded-xl bg-skin-card p-6 ring-1 ring-inset ring-gray-900/10">
                    <h3 class="mb-2 font-heading font-semibold text-gray-900">
                        {{  __('pages/faq.card.thirteen.title') }}
                    </h3>
                    <div class="prose prose-sm leading-5">
                        <p>
                            {{  __('pages/faq.card.thirteen.description_one') }}
                        </p>
                        <p>
                            {{  __('pages/faq.card.thirteen.description_part_two') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
