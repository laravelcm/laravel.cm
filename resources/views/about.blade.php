<x-app-layout title="A propos de Laravel Cameroun">

    <x-container>
        <header class="py-8 sm:py-10 lg:py-12 lg:grid lg:grid-cols-2 lg:gap-x-12">
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:text-left lg:mx-0">
                <h1 class="text-skin-inverted">
                    <span class="block text-sm font-semibold text-skin-primary sm:text-base lg:text-sm xl:text-base">
                        À propos
                    </span>
                    <span class="mt-2 block text-2xl tracking-tight font-extrabold sm:text-3xl xl:text-4xl xl:leading-[3rem]">
                        Nous construisons une communauté Open Source d'apprenants et d'enseignants
                    </span>
                </h1>
            </div>
            <div class="mt-8 sm:text-center lg:text-left">
                <p class="text-base leading-6 font-normal text-skin-base sm:text-lg">
                    <span class="font-medium text-skin-inverted"><span class="text-skin-primary italic">"</span>Tout le monde enseigne, tout le monde apprend<span class="text-skin-primary italic">"</span></span>.
                    Tel est l'esprit qui est derrière la communauté. Une communauté qui se veut grandissante et qui donne la possibilité à tout le monde de partager ses connaissances et d'apprendre.
                </p>
            </div>
        </header>

        <section class="my-10" aria-describedby="stats section">
            <dl class="rounded-xl ring-1 ring-green-200 bg-green-50 sm:grid sm:grid-cols-3">
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-green-900">
                        Membres sur Slack
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-green-600 font-heading">
                        +300
                    </dd>
                </div>
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-green-900">
                        Membres sur Telegram
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-green-600 font-heading">
                        +700
                    </dd>
                </div>
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-green-900">
                        Membres sur WhatsApp
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-green-600 font-heading">
                        +350
                    </dd>
                </div>
            </dl>
        </section>

        <div class="max-w-3xl mx-auto py-8 sm:py-10 lg:py-12 xl:pb-20 lg:max-w-none">
            <h1 class="font-sans text-skin-inverted">
                <span class="block text-sm font-semibold text-skin-primary sm:text-base lg:text-sm xl:text-base">Notre histoire</span>
                <span class="mt-1 block text-xl tracking-tight font-extrabold font-heading sm:text-2xl xl:text-3xl">
                    Nous commençons tout juste
                </span>
            </h1>

            <div class="mt-5 prose prose-lg prose-green text-skin-base lg:max-w-none">
                <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
                    <div>
                        <p>
                            Lancé en Juin 2018, Laravel CM a rapidement commencé à se développer et à démarrer ses activités par un premier
                            Meetup pour sa présentation globale et ses objectifs. Ce Meetup a enregistré plus de 100 participants.
                        </p>
                        <p>
                            Durant cet événement, nous avons notamment enregistré la participation des entreprises telles que:
                        </p>
                        <ul class="font-normal">
                            <li>L'incubateur <a href="http://activspaces.com">ActivSpaces</a> qui a hébergé le meetup.</li>
                            <li>L'entreprise <span class="text-skin-primary font-medium">Kerawa Cameroun</span> qui a été l'un de nos sponsors.</li>
                            <li>La StartUp <a href="https://johns-corporation.com">John's Corporation</a> qui a été un sponsor et nous a soutenu dans la communication.</li>
                            <li>La StartUp <a href="https://twitter.com/DarkCodeCompany">Dark Code</a> qui nous a apporté son soutien dans la mise en place des supports de communication.</li>
                            <li>L'entreprise <a href="https://diool.com">Diool</a> sponsor du Meetup.</li>
                        </ul>
                        <p>
                            Laravel Cameroun est une communauté de développeurs et de designers qui se réunissent pour s'entraider.
                            L'industrie du logiciel reposant sur la collaboration et l'apprentissage en réseau.
                            Nous nous sommes donnés comme objectif de pouvoir rassembler le maximum de développeurs
                            et designers évoluant au Cameroun et dans l'Afrique Francophone pour organiser des grands
                            événements et Meetup partout dans le Cameroun et en Afrique Francophone.
                        </p>
                    </div>
                    <div class="mt-14 gap-4 columns-2 sm:columns-3 lg:mt-0">
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778123/IMG_1637_yjaqrk.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                            <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778121/IMG_1505_j06cwz.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[1/2]">
                            <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778122/IMG_1609_otohw5.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[2/5]">
                            <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778121/IMG_1605_zdgdpv.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[4/5]">
                            <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778122/IMG_1567_hfy747.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                            <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703782759/phnnfnzxt8khtrth4qem.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[3/7]">
                            <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t border-skin-base pt-12 sm:mt-14 sm:pt-14">
                <div class="space-y-12 lg:grid lg:grid-cols-3 lg:gap-24 lg:space-y-0">
                    <div class="font-sans">
                        <span class="text-sm leading-5 text-skin-primary font-semibold tracking-wide uppercase">
                            Notre équipe
                        </span>
                        <h2 class="mt-2 text-2xl font-extrabold font-heading text-skin-inverted tracking-tight sm:text-3xl">
                            Équipe de direction
                        </h2>
                        <p class="mt-5 text-lg text-skin-base">
                            Laravel Cameroun est une idée qui a été initiée puis transformée
                            en une communauté par 2 développeurs parmi les plus influents au Cameroun.
                        </p>
                    </div>
                    <div class="lg:col-span-2">
                        <ul role="list" class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:gap-x-8">
                            <li>
                                <div class="space-y-4">
                                    <img class="w-16 h-16 rounded-full lg:w-20 lg:h-20" src="https://avatars.githubusercontent.com/u/14105989?v=4" alt="Arthur Monney">
                                    <div class="text-lg leading-6 text-skin-inverted font-medium space-y-1">
                                        <h3>Arthur Monney</h3>
                                        <p class="text-base text-green-600 font-sans">Développeur Web Fullstack</p>
                                    </div>
                                    <div class="text-lg">
                                        <p class="text-skin-base">
                                            Créateur de
                                            <a href="https://github.com/shopperlabs/shopper" target="_blank" class="text-skin-primary hover:text-skin-primary-hover">
                                                @laravelshopper
                                            </a> -
                                            Laravel Cameroon (@laravelcm) et GDG Douala Organizer.
                                        </p>
                                    </div>

                                    <ul role="list" class="flex space-x-4">
                                        <li>
                                            <a href="https://twitter.com/MonneyArthur" class="text-skin-muted hover:text-skin-base">
                                                <span class="sr-only">Twitter</span>
                                                <x-icon.twitter class="w-6 h-6" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://github.com/mckenziearts" class="text-skin-muted hover:text-skin-base">
                                                <span class="sr-only">Github</span>
                                                <x-icon.github class="w-6 h-6" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/in/arthurmonney" class="text-skin-muted hover:text-skin-base">
                                                <span class="sr-only">LinkedIn</span>
                                                <x-icon.linkedin class="w-6 h-6" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="space-y-4">
                                    <img class="w-16 h-16 rounded-full lg:w-20 lg:h-20" src="https://avatars.githubusercontent.com/u/4902424?v=4" alt="Fabrice Yopa">
                                    <div class="text-lg leading-6 text-skin-inverted font-medium space-y-1">
                                        <h3>Fabrice Yopa</h3>
                                        <p class="text-base text-green-600 font-sans">Co-Founder & CTO IS Dev Experts</p>
                                    </div>
                                    <div class="text-lg">
                                        <p class="text-skin-base font-normal">
                                            CTO at @isdevexperts, Expert Lead Dev Web.
                                            Laravel Cameroon Organizer @laravelcm
                                        </p>
                                    </div>

                                    <ul role="list" class="flex space-x-4">
                                        <li>
                                            <a href="https://twitter.com/yopafabrice" class="text-skin-muted hover:text-skin-base">
                                                <span class="sr-only">Twitter</span>
                                                <x-icon.twitter class="w-6 h-6" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://github.com/fabriceyopa" class="text-skin-muted hover:text-skin-base">
                                                <span class="sr-only">Github</span>
                                                <x-icon.github class="w-6 h-6" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/in/fabriceyopa" class="text-skin-muted hover:text-skin-base">
                                                <span class="sr-only">LinkedIn</span>
                                                <x-icon.linkedin class="w-6 h-6" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </x-container>

</x-app-layout>
