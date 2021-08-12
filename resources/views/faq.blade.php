@title(__('FAQ'))

@extends('layouts.default')

@section('body')

    <div class="mb-14">
        <h2 class="text-3xl font-extrabold text-skin-inverted lg:text-4xl font-sans">
            {{ __('Foire aux questions 🤔') }}
        </h2>
        <p class="mt-2 text-sm text-skin-muted font-normal lg:text-base">{{ __("Certaines d'entre elles ne sont pas demandées fréquemment, mais elles sont toujours bonnes à savoir.") }}</p>
    </div>

    <div id="faq-questions" class="text-base flex -mx-2 -mt-4">
        <div class="flex-none px-2 w-full md:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">{{ __("Qui peut publier des articles sur Laravel.cm?") }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre
                        <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais apres validation votre article peut-etre rendu public sur le fil d'actualite de la communaute et envoye en notification sur le compte Twitter de la communaute.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Qui peut publier sur Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Tout le monde! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What JS framework does Tailwind UI use?</h3>
                <div class="prose prose-sm leading-5"><p>All of the examples in Tailwind UI are provided in three formats: React, Vue, and vanilla HTML.</p>
                    <p>The React and Vue examples are fully functional out-of-the-box, and are powered by <a href="https://headlessui.dev">Headless UI</a> — a library of unstyled components we designed to integrate perfectly with Tailwind CSS.</p>
                    <p>The vanilla HTML examples <strong>do not include any JavaScript</strong> and are designed for people who prefer to write any necessary JavaScript themselves.</p>
                    <p>Most of the components do not rely on JS at all, but for the ones that do (dropdowns, modals, etc.) we've provided some simple comments in the HTML to explain things like what classes you need use for different states (like a toggle switch being on or off), or what classes we recommend for transitioning elements on to or off of the screen (like a modal opening).</p>
                    <p>To get a better idea of how this looks in practice, <a href="/documentation#integrating-with-javascript-frameworks">check out our documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What version of Tailwind CSS is used?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are authored using Tailwind CSS v2.0.</p>
                    <p>Learn more about this in our <a href="/documentation">getting started documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "free updates" include?</h3>
                <div class="prose prose-sm leading-5"><p>We regularly add new Marketing and Application UI components whenever we have new ideas and all new components added to those categories will be always be totally free for existing customers.</p>
                    <p>To see what our previous updates have looked like, <a href="/changelog">check out our changelog</a>.</p>
                    <p>We do plan to work on new component kits in the future that will be sold separately (email templates and e-commerce are ideas we've tossed around), but any components we design and build that belong in an existing kit will always be added as a free update.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What browsers does Tailwind UI support?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are designed to work in the latest, stable releases of all major browsers, including Chrome, Firefox, Safari, and Edge.</p>
                    <p>We don't support Internet Explorer 11.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Does Tailwind UI include Figma, Sketch, or Adobe XD files?</h3>
                <div class="prose prose-sm leading-5"><p>No, Tailwind UI does not include design assets for tools like Figma, Sketch, or Adobe XD.</p>
                    <p>We don't produce high-quality design artifacts as part of our own design and development process, so building these extra resources means we can't spend as much time creating new examples in code which is where we believe we can provide the most value.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "community access" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Any purchase of Tailwind UI includes access to our private Discord server where you can suggest new component ideas, ask your peers for help with any problems you run into, and talk with other users about building things with Tailwind UI.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "unlimited projects" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Unlike most other templates/themes, you don't have to buy a new Tailwind UI license every time you want to use it on a new project.</p>
                    <p>As long as what you're building will be owned by the Tailwind UI license holder, you can build as many sites as you want without ever having to buy an additional license.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for client projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yes! You can use Tailwind UI for basically anything — the only thing we disallow is using it to create derivative competing products.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for my own commercial projects?</h3>
                <div class="prose prose-sm leading-5"><p>Absolutely! Your license gives you permission to build as many of your own projects as you like, whether those are simple public websites or SaaS applications that end users need to pay to access.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI in open source projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yep! As long as what you're building is some sort of actual website and not a derivative component library, theme builder, or other product where the primary purpose is clearly to repackage and redistribute our components, it's totally okay for that project to be open source.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I sell templates/themes I build with Tailwind UI?</h3>
                <div class="prose prose-sm leading-5"><p>No, you cannot use Tailwind UI to create derivative products like themes, UI kits, page builders, or anything else where you would be repackaging and redistributing our components for someone else to use to build their own sites.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What is your refund policy?</h3>
                <div class="prose prose-sm leading-5"><p>If you're unhappy with your purchase for any reason, email us at <a href="mailto:support@tailwindui.com">support@tailwindui.com</a> within 90 days and we'll refund you in full, no questions asked.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/2 hidden md:block lg:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Qui peut publier sur Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Tout le monde! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What JS framework does Tailwind UI use?</h3>
                <div class="prose prose-sm leading-5"><p>All of the examples in Tailwind UI are provided in three formats: React, Vue, and vanilla HTML.</p>
                    <p>The React and Vue examples are fully functional out-of-the-box, and are powered by <a href="https://headlessui.dev">Headless UI</a> — a library of unstyled components we designed to integrate perfectly with Tailwind CSS.</p>
                    <p>The vanilla HTML examples <strong>do not include any JavaScript</strong> and are designed for people who prefer to write any necessary JavaScript themselves.</p>
                    <p>Most of the components do not rely on JS at all, but for the ones that do (dropdowns, modals, etc.) we've provided some simple comments in the HTML to explain things like what classes you need use for different states (like a toggle switch being on or off), or what classes we recommend for transitioning elements on to or off of the screen (like a modal opening).</p>
                    <p>To get a better idea of how this looks in practice, <a href="/documentation#integrating-with-javascript-frameworks">check out our documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What version of Tailwind CSS is used?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are authored using Tailwind CSS v2.0.</p>
                    <p>Learn more about this in our <a href="/documentation">getting started documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "free updates" include?</h3>
                <div class="prose prose-sm leading-5"><p>We regularly add new Marketing and Application UI components whenever we have new ideas and all new components added to those categories will be always be totally free for existing customers.</p>
                    <p>To see what our previous updates have looked like, <a href="/changelog">check out our changelog</a>.</p>
                    <p>We do plan to work on new component kits in the future that will be sold separately (email templates and e-commerce are ideas we've tossed around), but any components we design and build that belong in an existing kit will always be added as a free update.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What browsers does Tailwind UI support?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are designed to work in the latest, stable releases of all major browsers, including Chrome, Firefox, Safari, and Edge.</p>
                    <p>We don't support Internet Explorer 11.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Does Tailwind UI include Figma, Sketch, or Adobe XD files?</h3>
                <div class="prose prose-sm leading-5"><p>No, Tailwind UI does not include design assets for tools like Figma, Sketch, or Adobe XD.</p>
                    <p>We don't produce high-quality design artifacts as part of our own design and development process, so building these extra resources means we can't spend as much time creating new examples in code which is where we believe we can provide the most value.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "community access" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Any purchase of Tailwind UI includes access to our private Discord server where you can suggest new component ideas, ask your peers for help with any problems you run into, and talk with other users about building things with Tailwind UI.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/2 hidden md:block lg:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">{{ __("Qui peut publier les articles sur Laravel.cm?") }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre
                        <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais apres validation votre article peut-etre rendu public sur le fil d'actualite de la communaute et envoye en notification sur le compte Twitter de la communaute.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "unlimited projects" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Unlike most other templates/themes, you don't have to buy a new Tailwind UI license every time you want to use it on a new project.</p>
                    <p>As long as what you're building will be owned by the Tailwind UI license holder, you can build as many sites as you want without ever having to buy an additional license.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for client projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yes! You can use Tailwind UI for basically anything — the only thing we disallow is using it to create derivative competing products.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for my own commercial projects?</h3>
                <div class="prose prose-sm leading-5"><p>Absolutely! Your license gives you permission to build as many of your own projects as you like, whether those are simple public websites or SaaS applications that end users need to pay to access.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI in open source projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yep! As long as what you're building is some sort of actual website and not a derivative component library, theme builder, or other product where the primary purpose is clearly to repackage and redistribute our components, it's totally okay for that project to be open source.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I sell templates/themes I build with Tailwind UI?</h3>
                <div class="prose prose-sm leading-5"><p>No, you cannot use Tailwind UI to create derivative products like themes, UI kits, page builders, or anything else where you would be repackaging and redistributing our components for someone else to use to build their own sites.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What is your refund policy?</h3>
                <div class="prose prose-sm leading-5"><p>If you're unhappy with your purchase for any reason, email us at <a href="mailto:support@tailwindui.com">support@tailwindui.com</a> within 90 days and we'll refund you in full, no questions asked.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Qui peut publier sur Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Tout le monde! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What JS framework does Tailwind UI use?</h3>
                <div class="prose prose-sm leading-5"><p>All of the examples in Tailwind UI are provided in three formats: React, Vue, and vanilla HTML.</p>
                    <p>The React and Vue examples are fully functional out-of-the-box, and are powered by <a href="https://headlessui.dev">Headless UI</a> — a library of unstyled components we designed to integrate perfectly with Tailwind CSS.</p>
                    <p>The vanilla HTML examples <strong>do not include any JavaScript</strong> and are designed for people who prefer to write any necessary JavaScript themselves.</p>
                    <p>Most of the components do not rely on JS at all, but for the ones that do (dropdowns, modals, etc.) we've provided some simple comments in the HTML to explain things like what classes you need use for different states (like a toggle switch being on or off), or what classes we recommend for transitioning elements on to or off of the screen (like a modal opening).</p>
                    <p>To get a better idea of how this looks in practice, <a href="/documentation#integrating-with-javascript-frameworks">check out our documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What version of Tailwind CSS is used?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are authored using Tailwind CSS v2.0.</p>
                    <p>Learn more about this in our <a href="/documentation">getting started documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "free updates" include?</h3>
                <div class="prose prose-sm leading-5"><p>We regularly add new Marketing and Application UI components whenever we have new ideas and all new components added to those categories will be always be totally free for existing customers.</p>
                    <p>To see what our previous updates have looked like, <a href="/changelog">check out our changelog</a>.</p>
                    <p>We do plan to work on new component kits in the future that will be sold separately (email templates and e-commerce are ideas we've tossed around), but any components we design and build that belong in an existing kit will always be added as a free update.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What browsers does Tailwind UI support?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are designed to work in the latest, stable releases of all major browsers, including Chrome, Firefox, Safari, and Edge.</p>
                    <p>We don't support Internet Explorer 11.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Does Tailwind UI include Figma, Sketch, or Adobe XD files?</h3>
                <div class="prose prose-sm leading-5"><p>No, Tailwind UI does not include design assets for tools like Figma, Sketch, or Adobe XD.</p>
                    <p>We don't produce high-quality design artifacts as part of our own design and development process, so building these extra resources means we can't spend as much time creating new examples in code which is where we believe we can provide the most value.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "community access" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Any purchase of Tailwind UI includes access to our private Discord server where you can suggest new component ideas, ask your peers for help with any problems you run into, and talk with other users about building things with Tailwind UI.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "unlimited projects" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Unlike most other templates/themes, you don't have to buy a new Tailwind UI license every time you want to use it on a new project.</p>
                    <p>As long as what you're building will be owned by the Tailwind UI license holder, you can build as many sites as you want without ever having to buy an additional license.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for client projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yes! You can use Tailwind UI for basically anything — the only thing we disallow is using it to create derivative competing products.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">{{ __("Qui peut publier les articles sur Laravel.cm?") }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>Les modérateurs! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                    <p>Mais apres validation votre article peut-etre rendu public sur le fil d'actualite de la communaute et envoye en notification sur le compte Twitter de la communaute.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for my own commercial projects?</h3>
                <div class="prose prose-sm leading-5"><p>Absolutely! Your license gives you permission to build as many of your own projects as you like, whether those are simple public websites or SaaS applications that end users need to pay to access.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI in open source projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yep! As long as what you're building is some sort of actual website and not a derivative component library, theme builder, or other product where the primary purpose is clearly to repackage and redistribute our components, it's totally okay for that project to be open source.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I sell templates/themes I build with Tailwind UI?</h3>
                <div class="prose prose-sm leading-5"><p>No, you cannot use Tailwind UI to create derivative products like themes, UI kits, page builders, or anything else where you would be repackaging and redistributing our components for someone else to use to build their own sites.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What is your refund policy?</h3>
                <div class="prose prose-sm leading-5"><p>If you're unhappy with your purchase for any reason, email us at <a href="mailto:support@tailwindui.com">support@tailwindui.com</a> within 90 days and we'll refund you in full, no questions asked.</p>
                </div>
            </div>
        </div>
    </div>

@stop
