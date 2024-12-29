<?php

declare(strict_types=1);

namespace Database\Seeders\Fixtures;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class ArticleTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersIds = User::all()->modelKeys();
        $tagsIds = Tag::query()
            ->whereJsonContains('concerns', ['post'])
            ->get()
            ->modelKeys();

        /** @var Article $article1 */
        $article1 = Article::query()->create([
            'title' => $name = 'Voyager - The Missing Laravel Admin',
            'slug' => $name,
            'body' => "
                # **V**oyager - The Missing Laravel Admin
Made with ❤️ by [The Control Group](https://www.thecontrolgroup.com)

![Voyager Screenshot](https://s3.amazonaws.com/thecontrolgroup/voyager-screenshot.png)

Website & Documentation: https://voyager.devdojo.com/

Video Tutorial Here: https://voyager.devdojo.com/academy/

Join our Slack chat: https://voyager-slack-invitation.herokuapp.com/

View the Voyager Cheat Sheet: https://voyager-cheatsheet.ulties.com/

<hr>

Laravel Admin & BREAD System (Browse, Read, Edit, Add, & Delete), supporting Laravel 8 and newer!

> Want to use Laravel 6 or 7? Use [Voyager 1.5](https://github.com/the-control-group/voyager/tree/1.5)

## Installation Steps

### 1. Require the Package

After creating your new Laravel application you can include the Voyager package with the following command:

```bash
composer require tcg/voyager
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

You will also want to update your website URL inside of the `APP_URL` variable inside the .env file:

```
APP_URL=http://localhost:8000
```

### 3. Run The Installer

Lastly, we can install voyager. You can do this either with or without dummy data.
The dummy data will include 1 admin account (if no users already exists), 1 demo page, 4 demo posts, 2 categories and 7 settings.

To install Voyager without dummy simply run

```bash
php artisan voyager:install
```

If you prefer installing it with dummy run

```bash
php artisan voyager:install --with-dummy
```

And we're all good to go!

Start up a local development server with `php artisan serve` And, visit [http://localhost:8000/admin](http://localhost:8000/admin).

## Creating an Admin User

If you did go ahead with the dummy data, a user should have been created for you with the following login credentials:

>**email:** `admin@admin.com`
>**password:** `password`

NOTE: Please note that a dummy user is **only** created if there are no current users in your database.

If you did not go with the dummy user, you may wish to assign admin privileges to an existing user.
This can easily be done by running this command:

```bash
php artisan voyager:admin your@email.com
```

If you did not install the dummy data and you wish to create a new admin user, you can pass the `--create` flag, like so:

```bash
php artisan voyager:admin your@email.com --create
```

And you will be prompted for the user's name and password.
            ",
            'published_at' => now(),
            'submitted_at' => now()->subHour(),
            'approved_at' => now(),
            'show_toc' => false,
            'canonical_url' => null,
            'user_id' => (int) array_rand($usersIds),
        ]);
        $article1->syncTags(array_rand($tagsIds, 3));
        $article1->addMediaFromUrl("https://unsplash.it/1920/1080?random={$article1->id}")
            ->toMediaCollection('media');

        /** @var Article $article2 */
        $article2 = Article::query()->create([
            'title' => $name = 'Awesome of awesome',
            'slug' => $name,
            'body' => "
                ## Contents

- [Platforms](#platforms)
- [Programming Languages](#programming-languages)
- [Front-End Development](#front-end-development)
- [Back-End Development](#back-end-development)
- [Computer Science](#computer-science)
- [Big Data](#big-data)
- [Theory](#theory)
- [Books](#books)
- [Editors](#editors)
- [Gaming](#gaming)
- [Development Environment](#development-environment)
- [Entertainment](#entertainment)
- [Databases](#databases)
- [Media](#media)
- [Learn](#learn)
- [Security](#security)
- [Content Management Systems](#content-management-systems)
- [Hardware](#hardware)
- [Business](#business)
- [Work](#work)
- [Networking](#networking)
- [Decentralized Systems](#decentralized-systems)
- [Health and Social Science](#health-and-social-science)
- [Events](#events)
- [Testing](#testing)
- [Miscellaneous](#miscellaneous)
- [Related](#related)

## Platforms

- [Node.js](https://github.com/sindresorhus/awesome-nodejs#readme) - Async non-blocking event-driven JavaScript runtime built on Chrome's V8 JavaScript engine.
	- [Cross-Platform](https://github.com/bcoe/awesome-cross-platform-nodejs#readme) - Writing cross-platform code on Node.js.
- [Frontend Development](https://github.com/dypsilon/frontend-dev-bookmarks#readme)
- [iOS](https://github.com/vsouza/awesome-ios#readme) - Mobile operating system for Apple phones and tablets.
- [Android](https://github.com/JStumpp/awesome-android#readme) - Mobile operating system developed by Google.
- [IoT & Hybrid Apps](https://github.com/weblancaster/awesome-IoT-hybrid#readme)
- [Electron](https://github.com/sindresorhus/awesome-electron#readme) - Cross-platform native desktop apps using JavaScript/HTML/CSS.
- [Cordova](https://github.com/busterc/awesome-cordova#readme) - JavaScript API for hybrid apps.
- [React Native](https://github.com/jondot/awesome-react-native#readme) - JavaScript framework for writing natively rendering mobile apps for iOS and Android.
- [Xamarin](https://github.com/XamSome/awesome-xamarin#readme) - Mobile app development IDE, testing, and distribution.
- [Linux](https://github.com/inputsh/awesome-linux#readme)
	- [Containers](https://github.com/Friz-zy/awesome-linux-containers#readme)
	- [eBPF](https://github.com/zoidbergwill/awesome-ebpf#readme) - Virtual machine that allows you to write more efficient and powerful tracing and monitoring for Linux systems.
	- [Arch-based Projects](https://github.com/PandaFoss/Awesome-Arch#readme) - Linux distributions and projects based on Arch Linux.
	- [AppImage](https://github.com/AppImage/awesome-appimage#readme) - Package apps in a single file that works on various mainstream Linux distributions.
- macOS - Operating system for Apple's Mac computers.
	- [Screensavers](https://github.com/agarrharr/awesome-macos-screensavers#readme)
	- [Apps](https://github.com/jaywcjlove/awesome-mac#readme)
	- [Open Source Apps](https://github.com/serhii-londar/open-source-mac-os-apps#readme)
- [watchOS](https://github.com/yenchenlin/awesome-watchos#readme) - Operating system for the Apple Watch.
- [JVM](https://github.com/deephacks/awesome-jvm#readme)
- [Salesforce](https://github.com/mailtoharshit/awesome-salesforce#readme)
- [Amazon Web Services](https://github.com/donnemartin/awesome-aws#readme)
- [Windows](https://github.com/Awesome-Windows/Awesome#readme)
- [IPFS](https://github.com/ipfs/awesome-ipfs#readme) - P2P hypermedia protocol.
- [Fuse](https://github.com/fuse-compound/awesome-fuse#readme) - Mobile development tools.
- [Heroku](https://github.com/ianstormtaylor/awesome-heroku#readme) - Cloud platform as a service.
- [Raspberry Pi](https://github.com/thibmaek/awesome-raspberry-pi#readme) - Credit card-sized computer aimed at teaching kids programming, but capable of a lot more.
- [Qt](https://github.com/JesseTG/awesome-qt#readme) - Cross-platform GUI app framework.
- [WebExtensions](https://github.com/fregante/Awesome-WebExtensions#readme) - Cross-browser extension system.
- [Smart TV](https://github.com/vitalets/awesome-smart-tv#readme) - Create apps for different TV platforms.
- [GNOME](https://github.com/Kazhnuz/awesome-gnome#readme) - Simple and distraction-free desktop environment for Linux.
- [KDE](https://github.com/francoism90/awesome-kde#readme) - A free software community dedicated to creating an open and user-friendly computing experience.
- [.NET](https://github.com/quozd/awesome-dotnet#readme)
	- [Core](https://github.com/thangchung/awesome-dotnet-core#readme)
	- [Roslyn](https://github.com/ironcev/awesome-roslyn#readme) - Open-source compilers and code analysis APIs for C# and VB.NET languages.
- [Amazon Alexa](https://github.com/miguelmota/awesome-amazon-alexa#readme) - Virtual home assistant.
- [DigitalOcean](https://github.com/jonleibowitz/awesome-digitalocean#readme) - Cloud computing platform designed for developers.
- [Flutter](https://github.com/Solido/awesome-flutter#readme) - Google's mobile SDK for building native iOS and Android apps from a single codebase written in Dart.
- [Home Assistant](https://github.com/frenck/awesome-home-assistant#readme) - Open source home automation that puts local control and privacy first.
- [IBM Cloud](https://github.com/victorshinya/awesome-ibmcloud#readme) - Cloud platform for developers and companies.
- [Firebase](https://github.com/jthegedus/awesome-firebase#readme) - App development platform built on Google Cloud Platform.
- [Robot Operating System 2.0](https://github.com/fkromer/awesome-ros2#readme) - Set of software libraries and tools that help you build robot apps.
- [Adafruit IO](https://github.com/adafruit/awesome-adafruitio#readme) - Visualize and store data from any device.
- [Cloudflare](https://github.com/irazasyed/awesome-cloudflare#readme) - CDN, DNS, DDoS protection, and security for your site.
- [Actions on Google](https://github.com/ravirupareliya/awesome-actions-on-google#readme) - Developer platform for Google Assistant.
- [ESP](https://github.com/agucova/awesome-esp#readme) - Low-cost microcontrollers with WiFi and broad IoT applications.
- [Deno](https://github.com/denolib/awesome-deno#readme) - A secure runtime for JavaScript and TypeScript that uses V8 and is built in Rust.
- [DOS](https://github.com/balintkissdev/awesome-dos#readme) - Operating system for x86-based personal computers that was popular during the 1980s and early 1990s.
- [Nix](https://github.com/nix-community/awesome-nix#readme) - Package manager for Linux and other Unix systems that makes package management reliable and reproducible.
- [Integration](https://github.com/stn1slv/awesome-integration#readme) - Linking together different IT systems (components) to functionally cooperate as a whole.
- [Node-RED](https://github.com/naimo84/awesome-nodered#readme) - A programming tool for wiring together hardware devices, APIs, and online services.
- [Low Code](https://github.com/zenitysec/awesome-low-code#readme) - Allowing business professionals to address their needs on their own with little to no coding skills.
- [Capacitor](https://github.com/riderx/awesome-capacitor#readme) - Cross-platform open source runtime for building Web Native apps.
- [ArcGIS Developer](https://github.com/Esri/awesome-arcgis-developer#readme) - Mapping and location analysis platform for developers.

## Programming Languages

- [JavaScript](https://github.com/sorrycc/awesome-javascript#readme)
	- [Promises](https://github.com/wbinnssmith/awesome-promises#readme)
	- [Standard Style](https://github.com/standard/awesome-standard#readme) - Style guide and linter.
	- [Must Watch Talks](https://github.com/bolshchikov/js-must-watch#readme)
	- [Tips](https://github.com/loverajoel/jstips#readme)
	- [Network Layer](https://github.com/Kikobeats/awesome-network-js#readme)
	- [Micro npm Packages](https://github.com/parro-it/awesome-micro-npm-packages#readme)
	- [Mad Science npm Packages](https://github.com/feross/awesome-mad-science#readme) - Impossible sounding projects that exist.
	- [Maintenance Modules](https://github.com/maxogden/maintenance-modules#readme) - For npm packages.
	- [npm](https://github.com/sindresorhus/awesome-npm#readme) - Package manager.
	- [AVA](https://github.com/avajs/awesome-ava#readme) - Test runner.
	- [ESLint](https://github.com/dustinspecker/awesome-eslint#readme) - Linter.
	- [Functional Programming](https://github.com/stoeffel/awesome-fp-js#readme)
	- [Observables](https://github.com/sindresorhus/awesome-observables#readme)
	- [npm scripts](https://github.com/RyanZim/awesome-npm-scripts#readme) - Task runner.
	- [30 Seconds of Code](https://github.com/30-seconds/30-seconds-of-code#readme) - Code snippets you can understand in 30 seconds.
	- [Ponyfills](https://github.com/Richienb/awesome-ponyfills#readme) - Like polyfills but without overriding native APIs.
- [Swift](https://github.com/matteocrippa/awesome-swift#readme) - Apple's compiled programming language that is secure, modern, programmer-friendly, and fast.
	- [Education](https://github.com/hsavit1/Awesome-Swift-Education#readme)
	- [Playgrounds](https://github.com/uraimo/Awesome-Swift-Playgrounds#readme)
- [Python](https://github.com/vinta/awesome-python#readme) - General-purpose programming language designed for readability.
	- [Asyncio](https://github.com/timofurrer/awesome-asyncio#readme) - Asynchronous I/O in Python 3.
	- [Scientific Audio](https://github.com/faroit/awesome-python-scientific-audio#readme) - Scientific research in audio/music.
	- [CircuitPython](https://github.com/adafruit/awesome-circuitpython#readme) - A version of Python for microcontrollers.
	- [Data Science](https://github.com/krzjoa/awesome-python-data-science#readme) - Data analysis and machine learning.
	- [Typing](https://github.com/typeddjango/awesome-python-typing#readme) - Optional static typing for Python.
	- [MicroPython](https://github.com/mcauser/awesome-micropython#readme) - A lean and efficient implementation of Python 3 for microcontrollers.
- [Rust](https://github.com/rust-unofficial/awesome-rust#readme)
- [Haskell](https://github.com/krispo/awesome-haskell#readme)
- [PureScript](https://github.com/passy/awesome-purescript#readme)
- [Go](https://github.com/avelino/awesome-go#readme)
- [Scala](https://github.com/lauris/awesome-scala#readme)
	- [Scala Native](https://github.com/tindzk/awesome-scala-native#readme) - Optimizing ahead-of-time compiler for Scala based on LLVM.
- [Ruby](https://github.com/markets/awesome-ruby#readme)
- [Clojure](https://github.com/razum2um/awesome-clojure#readme)
- [ClojureScript](https://github.com/hantuzun/awesome-clojurescript#readme)
- [Elixir](https://github.com/h4cc/awesome-elixir#readme)
- [Elm](https://github.com/sporto/awesome-elm#readme)
- [Erlang](https://github.com/drobakowski/awesome-erlang#readme)
- [Julia](https://github.com/svaksha/Julia.jl#readme) - High-level dynamic programming language designed to address the needs of high-performance numerical analysis and computational science.
- [Lua](https://github.com/LewisJEllis/awesome-lua#readme)
- [C](https://github.com/inputsh/awesome-c#readme)
- [C/C++](https://github.com/fffaraz/awesome-cpp#readme) - General-purpose language with a bias toward system programming and embedded, resource-constrained software.
- [R](https://github.com/qinwf/awesome-R#readme) - Functional programming language and environment for statistical computing and graphics.
	- [Learning](https://github.com/iamericfletcher/awesome-r-learning-resources#readme)
- [D](https://github.com/dlang-community/awesome-d#readme)
- [Common Lisp](https://github.com/CodyReichert/awesome-cl#readme) - Powerful dynamic multiparadigm language that facilitates iterative and interactive development.
	- [Learning](https://github.com/GustavBertram/awesome-common-lisp-learning#readme)
- [Perl](https://github.com/hachiojipm/awesome-perl#readme)
- [Groovy](https://github.com/kdabir/awesome-groovy#readme)
- [Dart](https://github.com/yissachar/awesome-dart#readme)
- [Java](https://github.com/akullpp/awesome-java#readme) - Popular secure object-oriented language designed for flexibility to 'write once, run anywhere'.
	- [RxJava](https://github.com/eleventigers/awesome-rxjava#readme)
- [Kotlin](https://github.com/KotlinBy/awesome-kotlin#readme)
- [OCaml](https://github.com/ocaml-community/awesome-ocaml#readme)
- [ColdFusion](https://github.com/seancoyne/awesome-coldfusion#readme)
- [Fortran](https://github.com/rabbiabram/awesome-fortran#readme)
- [PHP](https://github.com/ziadoz/awesome-php#readme) - Server-side scripting language.
	- [Composer](https://github.com/jakoch/awesome-composer#readme) - Package manager.
- [Pascal](https://github.com/Fr0sT-Brutal/awesome-pascal#readme)
- [AutoHotkey](https://github.com/ahkscript/awesome-AutoHotkey#readme)
- [AutoIt](https://github.com/J2TeaM/awesome-AutoIt#readme)
- [Crystal](https://github.com/veelenga/awesome-crystal#readme)
- [Frege](https://github.com/sfischer13/awesome-frege#readme) - Haskell for the JVM.
- [CMake](https://github.com/onqtam/awesome-cmake#readme) - Build, test, and package software.
- [ActionScript 3](https://github.com/robinrodricks/awesome-actionscript3#readme) - Object-oriented language targeting Adobe AIR.
- [Eta](https://github.com/sfischer13/awesome-eta#readme) - Functional programming language for the JVM.
- [Idris](https://github.com/joaomilho/awesome-idris#readme) - General purpose pure functional programming language with dependent types influenced by Haskell and ML.
- [Ada/SPARK](https://github.com/ohenley/awesome-ada#readme) - Modern programming language designed for large, long-lived apps where reliability and efficiency are essential.
- [Q#](https://github.com/ebraminio/awesome-qsharp#readme) - Domain-specific programming language used for expressing quantum algorithms.
- [Imba](https://github.com/koolamusic/awesome-imba#readme) - Programming language inspired by Ruby and Python and compiles to performant JavaScript.
- [Vala](https://github.com/desiderantes/awesome-vala#readme) - Programming language designed to take full advantage of the GLib and GNOME ecosystems, while preserving the speed of C code.
- [Coq](https://github.com/coq-community/awesome-coq#readme) - Formal language and environment for programming and specification which facilitates interactive development of machine-checked proofs.
- [V](https://github.com/vlang/awesome-v#readme) - Simple, fast, safe, compiled language for developing maintainable software.
- [Zig](https://github.com/catdevnull/awesome-zig#readme) - General-purpose programming language and toolchain for maintaining robust, optimal, and reusable software.
- [Move](https://github.com/MystenLabs/awesome-move#readme) - Domain-specific programming language for writing safe smart contracts.

## Front-End Development

- [ES6 Tools](https://github.com/addyosmani/es6-tools#readme)
- [Web Performance Optimization](https://github.com/davidsonfellipe/awesome-wpo#readme)
- [Web Tools](https://github.com/lvwzhen/tools#readme)
- [CSS](https://github.com/awesome-css-group/awesome-css#readme) - Style sheet language that specifies how HTML elements are displayed on screen.
	- [Critical-Path Tools](https://github.com/addyosmani/critical-path-css-tools#readme)
	- [Scalability](https://github.com/davidtheclark/scalable-css-reading-list#readme)
	- [Must-Watch Talks](https://github.com/AllThingsSmitty/must-watch-css#readme)
	- [Protips](https://github.com/AllThingsSmitty/css-protips#readme)
	- [Frameworks](https://github.com/troxler/awesome-css-frameworks#readme)
- [React](https://github.com/enaqx/awesome-react#readme) - JavaScript library for building user interfaces.
	- [Relay](https://github.com/expede/awesome-relay#readme) - Framework for building data-driven React apps.
	- [React Hooks](https://github.com/glauberfc/awesome-react-hooks#readme) - Lets you use state and other React features without writing a class.
- [Web Components](https://github.com/web-padawan/awesome-web-components#readme)
- [Polymer](https://github.com/Granze/awesome-polymer#readme) - JavaScript library to develop Web Components.
- [Angular](https://github.com/PatrickJS/awesome-angular#readme) - App framework.
- [Backbone](https://github.com/sadcitizen/awesome-backbone#readme) - App framework.
- [HTML5](https://github.com/diegocard/awesome-html5#readme) - Markup language used for websites & web apps.
- [SVG](https://github.com/willianjusten/awesome-svg#readme) - XML-based vector image format.
- [Canvas](https://github.com/raphamorim/awesome-canvas#readme)
- [KnockoutJS](https://github.com/dnbard/awesome-knockout#readme) - JavaScript library.
- [Dojo Toolkit](https://github.com/petk/awesome-dojo#readme) - JavaScript toolkit.
- [Inspiration](https://github.com/NoahBuscher/Inspire#readme)
- [Ember](https://github.com/ember-community-russia/awesome-ember#readme) - App framework.
- [Android UI](https://github.com/wasabeef/awesome-android-ui#readme)
- [iOS UI](https://github.com/cjwirth/awesome-ios-ui#readme)
- [Meteor](https://github.com/Urigo/awesome-meteor#readme)
- [BEM](https://github.com/sturobson/BEM-resources#readme)
- [Flexbox](https://github.com/afonsopacifer/awesome-flexbox#readme)
- [Web Typography](https://github.com/deanhume/typography#readme)
- [Web Accessibility](https://github.com/brunopulis/awesome-a11y#readme)
- [Material Design](https://github.com/sachin1092/awesome-material#readme)
- [D3](https://github.com/wbkd/awesome-d3#readme) - Library for producing dynamic, interactive data visualizations.
- [Emails](https://github.com/jonathandion/awesome-emails#readme)
- [jQuery](https://github.com/petk/awesome-jquery#readme) - Easy to use JavaScript library for DOM manipulation.
	- [Tips](https://github.com/AllThingsSmitty/jquery-tips-everyone-should-know#readme)
- [Web Audio](https://github.com/notthetup/awesome-webaudio#readme)
- [Offline-First](https://github.com/pazguille/offline-first#readme)
- [Static Website Services](https://github.com/agarrharr/awesome-static-website-services#readme)
- [Cycle.js](https://github.com/cyclejs-community/awesome-cyclejs#readme) - Functional and reactive JavaScript framework.
- [Text Editing](https://github.com/dok/awesome-text-editing#readme)
- [Motion UI Design](https://github.com/fliptheweb/motion-ui-design#readme)
- [Vue.js](https://github.com/vuejs/awesome-vue#readme) - App framework.
- [Marionette.js](https://github.com/sadcitizen/awesome-marionette#readme) - App framework.
- [Aurelia](https://github.com/aurelia-contrib/awesome-aurelia#readme) - App framework.
- [Charting](https://github.com/zingchart/awesome-charting#readme)
- [Ionic Framework 2](https://github.com/candelibas/awesome-ionic#readme)
- [Chrome DevTools](https://github.com/ChromeDevTools/awesome-chrome-devtools#readme)
- [PostCSS](https://github.com/jdrgomes/awesome-postcss#readme) - CSS tool.
- [Draft.js](https://github.com/nikgraf/awesome-draft-js#readme) - Rich text editor framework for React.
- [Service Workers](https://github.com/TalAter/awesome-service-workers#readme)
- [Progressive Web Apps](https://github.com/TalAter/awesome-progressive-web-apps#readme)
- [choo](https://github.com/choojs/awesome-choo#readme) - App framework.
- [Redux](https://github.com/brillout/awesome-redux#readme) - State container for JavaScript apps.
- [Browserify](https://github.com/browserify/awesome-browserify#readme) - Module bundler.
- [Sass](https://github.com/Famolus/awesome-sass#readme) - CSS preprocessor.
- [Ant Design](https://github.com/websemantics/awesome-ant-design#readme) - Enterprise-class UI design language.
- [Less](https://github.com/LucasBassetti/awesome-less#readme) - CSS preprocessor.
- [WebGL](https://github.com/sjfricke/awesome-webgl#readme) - JavaScript API for rendering 3D graphics.
- [Preact](https://github.com/preactjs/awesome-preact#readme) - App framework.
- [Progressive Enhancement](https://github.com/jbmoelker/progressive-enhancement-resources#readme)
- [Next.js](https://github.com/unicodeveloper/awesome-nextjs#readme) - Framework for server-rendered React apps.
- [lit](https://github.com/web-padawan/awesome-lit#readme) - Library for building web components with a declarative template system.
- [JAMstack](https://github.com/automata/awesome-jamstack#readme) - Modern web development architecture based on client-side JavaScript, reusable APIs, and prebuilt markup.
- [WordPress-Gatsby](https://github.com/henrikwirth/awesome-wordpress-gatsby#readme) - Web development technology stack with WordPress as a back end and Gatsby as a front end.
- [Mobile Web Development](https://github.com/myshov/awesome-mobile-web-development#readme) - Creating a great mobile web experience.
- [Storybook](https://github.com/lauthieb/awesome-storybook#readme) - Development environment for UI components.
- [Blazor](https://github.com/AdrienTorris/awesome-blazor#readme) - .NET web framework using C#/Razor and HTML that runs in the browser with WebAssembly.
- [PageSpeed Metrics](https://github.com/csabapalfi/awesome-pagespeed-metrics#readme) - Metrics to help understand page speed and user experience.
- [Tailwind CSS](https://github.com/aniftyco/awesome-tailwindcss#readme) - Utility-first CSS framework for rapid UI development.
- [Seed](https://github.com/seed-rs/awesome-seed-rs#readme) - Rust framework for creating web apps running in WebAssembly.
- [Web Performance Budget](https://github.com/pajaydev/awesome-web-performance-budget#readme) - Techniques to ensure certain performance metrics for a website.
- [Web Animation](https://github.com/sergey-pimenov/awesome-web-animation#readme) - Animations in the browser with JavaScript, CSS, SVG, etc.
- [Yew](https://github.com/jetli/awesome-yew#readme) - Rust framework inspired by Elm and React for creating multi-threaded frontend web apps with WebAssembly.
- [Material-UI](https://github.com/nadunindunil/awesome-material-ui#readme) - Material Design React components for faster and easier web development.
- [Building Blocks for Web Apps](https://github.com/componently-com/awesome-building-blocks-for-web-apps#readme) - Standalone features to be integrated into web apps.
- [Svelte](https://github.com/TheComputerM/awesome-svelte#readme) - App framework.
- [Design systems](https://github.com/klaufel/awesome-design-systems#readme) - Collection of reusable components, guided by rules that ensure consistency and speed.
- [Inertia.js](https://github.com/innocenzi/awesome-inertiajs#readme) - Make single-page apps without building an API.
- [MDBootstrap](https://github.com/mdbootstrap/awesome-mdbootstrap#readme) - Templates, layouts, components, and widgets to rapidly build websites.
- [Master CSS](https://github.com/master-co/awesome-master-css#readme) - A virtual CSS language with enhanced syntax.
- [Hydrogen](https://github.com/shopify/awesome-hydrogen#readme) - Edge-first framework for building Shopify storefronts with React.
            ",
            'published_at' => now()->addDay(),
            'submitted_at' => now()->addDay()->subHour(),
            'approved_at' => null,
            'show_toc' => true,
            'canonical_url' => null,
            'user_id' => (int) array_rand($usersIds),
        ]);
        $article2->syncTags(array_rand($tagsIds, 3));
        $article2->addMediaFromUrl("https://unsplash.it/1920/1080?random={$article2->id}")
            ->toMediaCollection('media');

        /** @var Article $article3 */
        $article3 = Article::query()->create([
            'title' => $name = 'React Email Editor',
            'slug' => $name,
            'body' => "
                The excellent drag-n-drop email editor by [Unlayer](https://unlayer.com/embed) as a [React.js](http://facebook.github.io/react) _wrapper component_. This is the most powerful and developer friendly visual email builder for your app.

|                                                          Video Overview                                                           |
| :-------------------------------------------------------------------------------------------------------------------------------: |
| [![React Email Editor](https://unroll-assets.s3.amazonaws.com/unlayervideotour.png)](https://www.youtube.com/watch?v=MIWhX-NF3j8) |
|                                       _Watch video overview: https://youtu.be/MIWhX-NF3j8_                                        |

## Live Demo

Check out the live demo here: http://react-email-editor-demo.netlify.com/ ([Source Code](https://github.com/unlayer/react-email-editor/blob/master/demo/src/index.js))

## Blog Post

Here's a blog post with a quickstart guide: https://medium.com/unlayer-blog/creating-a-drag-n-drop-email-editor-with-react-db1e9eb42386

## Installation

The easiest way to use React Email Editor is to install it from NPM and include it in your own React build process.

```shell
npm install react-email-editor --save
```

## Usage

Require the EmailEditor component and render it with JSX:

```javascript
import React, { useRef } from 'react';
import { render } from 'react-dom';

import EmailEditor from 'react-email-editor';

const App = (props) => {
  const emailEditorRef = useRef(null);

  const exportHtml = () => {
    emailEditorRef.current.editor.exportHtml((data) => {
      const { design, html } = data;
      console.log('exportHtml', html);
    });
  };

  const onLoad = () => {
    // editor instance is created
    // you can load your template here;
    // const templateJson = {};
    // emailEditorRef.current.editor.loadDesign(templateJson);
  }

  const onReady = () => {
    // editor is ready
    console.log('onReady');
  };

  return (
    <div>
      <div>
        <button onClick={exportHtml}>Export HTML</button>
      </div>

      <EmailEditor ref={emailEditorRef} onLoad={onLoad} onReady={onReady} />
    </div>
  );
};

render(<App />, document.getElementById('app'));
```

### Methods

| method         | params              | description                                             |
| -------------- | ------------------- | ------------------------------------------------------- |
| **loadDesign** | `Object data`       | Takes the design JSON and loads it in the editor        |
| **saveDesign** | `Function callback` | Returns the design JSON in a callback function          |
| **exportHtml** | `Function callback` | Returns the design HTML and JSON in a callback function |

See the [example source](https://github.com/unlayer/react-email-editor/blob/master/demo/src/index.js) for a reference implementation.

### Properties

- `editorId` `String` HTML div id of the container where the editor will be embedded (optional)
- `style` `Object` style object for the editor container (default {})
- `minHeight` `String` minimum height to initialize the editor with (default 500px)
- `onLoad` `Function` called when the editor instance is created
- `onReady` `Function` called when the editor has finished loading
- `options` `Object` options passed to the Unlayer editor instance (default {})
- `tools` `Object` configuration for the built-in and custom tools (default {})
- `appearance` `Object` configuration for appearance and theme (default {})
- `projectId` `Integer` Unlayer project ID (optional)

See the [Unlayer Docs](https://docs.unlayer.com/) for all available options.

## Custom Tools

Custom tools can help you add your own content blocks to the editor. Every application is different and needs different tools to reach it's full potential. [Learn More](https://docs.unlayer.com/docs/custom-tools)

[![Custom Tools](https://unroll-assets.s3.amazonaws.com/custom_tools.png)](https://docs.unlayer.com/docs/custom-tools)

## Localization

You can submit new language translations by creating a PR on this GitHub repo: https://github.com/unlayer/translations. Translations managed by [PhraseApp](https://phraseapp.com)

### License

Copyright (c) 2022 Unlayer. [MIT](LICENSE) Licensed.
            ",
            'published_at' => now(),
            'submitted_at' => now()->addHours(2),
            'approved_at' => now()->addHours(3),
            'show_toc' => array_rand([true, false]),
            'canonical_url' => null,
            'user_id' => (int) array_rand($usersIds),
        ]);
        $article3->syncTags(array_rand($tagsIds, 3));
        $article3->addMediaFromUrl("https://unsplash.it/1920/1080?random={$article3->id}")
            ->toMediaCollection('media');

        /** @var Article $article4 */
        $article4 = Article::query()->create([
            'title' => $name = 'Awesome Laravel Package, Tutorials, News',
            'slug' => $name,
            'body' => "
            A curated list of awesome bookmarks, packages, tutorials, videos and other cool resources from the Laravel ecosystem.

Inspired by [ziadoz/awesome-php](https://github.com/ziadoz/awesome-php)

## Table of Contents

- [Essentials](#essentials)
- [Packages](#packages)
- [Popular Packages](#popular-packages)
- [Development Setup](#development-setup)
- [Application Hosting](#application-hosting)
- [Application Deployment](#application-deployment)
- [Code Snippets](#code-snippets)
- [Tutorials & Blogs](#tutorials--blogs)
- [Videos](#videos)
- [Conferences](#conferences)
- [Books](#books)
- [Starter Projects](#starter-projects)
- [Codebases for Reference](#codebases-for-reference)
- [Content Management Systems](#content-management-systems)
- [Podcasts](#podcasts)
- [Community](#community)
- [Jobs](#jobs)
- [Hosted Development Tools](#hosted-development-tools)
- [Miscellaneous](#miscellaneous)

## Essentials

* [Laravel](https://laravel.com) ([Documentation](https://laravel.com/docs))
* [Laravel API Reference](https://laravel.com/api/master/)
* [Lumen](https://lumen.laravel.com) ([Documentation](https://lumen.laravel.com/docs))
* [Laracasts](https://laracasts.com)
* [Laravel News](https://laravel-news.com) ([Archive](https://laravel-news.com/archive/))

## Packages

* [Packagist](https://packagist.org/)
* [Laravel Collective](https://laravelcollective.com/)
* [Packalyst](http://packalyst.com/)
* [Spatie](https://spatie.be/en/opensource/laravel)

## Popular Packages

> This is a list of well-documented, tested packages that are frequently used in Laravel projects. If you're looking for an exhaustive list of PHP packages, then check out the Package Repositories mentioned above.

##### Developer Tools

* [Scaffold Interface](https://github.com/amranidev/scaffold-interface) - A Smart CRUD Generator For Laravel
* [IDE Helper](https://github.com/barryvdh/laravel-ide-helper) - Generates a helper file for IDE auto-completion
* [Laravel 5 Extended Generators](https://github.com/laracasts/Laravel-5-Generators-Extended) - Extends built-in file generators
* [Laravel API/Scaffold/CRUD Generator](https://github.com/InfyOmLabs/laravel-generator) - Generator for APIs, CRUD scaffolds etc.
* [Laravel Tinx](https://github.com/furey/tinx) - Reload your Laravel Tinker session from inside Tinker
* [Laravel API Documentation Generator](https://github.com/mpociot/laravel-apidoc-generator) - Automatically generate your API documentation
* [Laravel Packager](https://github.com/Jeroen-G/Laravel-Packager) - A CLI tool for creating Laravel packages
* [Workbench Export to Migrations](https://github.com/beckenrode/mysql-workbench-export-laravel-5-migrations) - Workbench plugin for exporting Models to Laravel migrations
* [Laravel Decomposer](https://github.com/lubusIN/laravel-decomposer) - List all installed packages, their dependencies, app & server details
* [LaRecipe](https://github.com/saleem-hadad/larecipe) - Write gorgeous documentations for your products using Markdown inside your Laravel app.
* [Prequel](https://github.com/Protoqol/Prequel/) - A clear and concise database management GUI tweaked for Laravel.

##### Testing & Debugging

* [Laravel TestTools](https://chrome.google.com/webstore/detail/laravel-testtools/ddieaepnbjhgcbddafciempnibnfnakl) - Chrome extension to generate Laravel integration tests while using your app
* [Laravel Test Factory Generator](https://github.com/mpociot/laravel-test-factory-helper) - Generate Laravel test factories from your existing models
* [Clockwork](https://github.com/itsgoingd/clockwork) - Integrates Clockwork Chrome extension for debugging and profiling apps
* [Debug Bar](https://github.com/barryvdh/laravel-debugbar) - Integrates PHP Debug Bar with Laravel
* [Ignition](https://github.com/facade/ignition) - A beautiful error page for Laravel apps
* [Laravel 5 Log Viewer](https://github.com/rap2hpoutre/laravel-log-viewer) - Log viewer
* [LogViewer](https://github.com/ARCANEDEV/LogViewer) - Provides a log viewer
* [LERN](https://github.com/tylercd100/lern#lern-laravel-exception-recorder-and-notifier) - Record exceptions into a database and will send you a notification
* [Mail Preview](https://github.com/themsaid/laravel-mail-preview) - Preview sent mail in a web browser or mail client
* [Laravel Tracy](https://github.com/recca0120/laravel-tracy) - A Laravel Package to integrate Nette Tracy Debugger
* [Laravel Terminal](https://github.com/recca0120/laravel-terminal) - run artisan in a web browser
* [Laravel API Tester](https://github.com/asvae/laravel-api-tester) - Postman-like tool with Laravel routes
* [Laravel Tail](https://github.com/spatie/laravel-tail) - The missing tail command
* [Laravel Telescope](https://github.com/laravel/telescope) - Laravel Telescope is an elegant debug assistant for the Laravel framework

##### Authentication & Authorization

* [Bouncer](https://github.com/JosephSilber/bouncer) - Roles & Permissions
* [Laratrust](https://github.com/santigarcor/laratrust) - Roles, Permissions and teams
* [Entrust](https://github.com/Zizaco/entrust) - Role-based Permissions
* [JWT Auth](https://github.com/tymondesigns/jwt-auth) - JSON Web Token authentication for APIs
* [Laravel Permission](https://github.com/spatie/laravel-permission) - Associate users with roles and permissions
* [Defender](https://github.com/artesaos/defender) - Roles & Permissions
* [OAuth2 Server Laravel](https://github.com/lucadegasperi/oauth2-server-laravel) - OAuth 2.0 authorization server and resource server
* [Socialite](https://github.com/laravel/socialite) - OAuth authentication with Facebook, Google, Twitter etc.
* [Socialite Providers 2.0](http://socialiteproviders.github.io/) - 100+ social authentication providers for Socialite with Lumen support
* [Google2FA](https://github.com/antonioribeiro/google2fa) - Google Two-Factor Authentication Module
* [Laravel User Verification](https://github.com/jrean/laravel-user-verification) - Handle the user verification flow and validate email
* [Adldap2 Laravel](https://github.com/Adldap2/Adldap2-Laravel) - LDAP authentication and Active Directory management
* [Doorman](https://github.com/clarkeash/doorman) - Limit access to your Laravel applications by using invite codes
* [Laravel Heyman](https://github.com/imanghafoori1/laravel-heyman) - Heyman continues where the above role-permission packages left off

##### Utilities

* [Awes.io](https://github.com/awes-io/awes-io) - boilerplate for CRM, SaaS, ERP based on Vue (Nuxt.js), TailwindCSS plus Laravel as a backend.
* [Artisan View](https://github.com/svenluijten/artisan-view) - Manage the views in Laravel projects via artisan
* [Bootstrapper](https://github.com/patricktalmadge/bootstrapper/) - Set of classes to create Bootstrap 3 markup
* [Captcha](https://github.com/mewebstudio/captcha) - An anti-bot image captcha system
* [Charts](https://github.com/ConsoleTVs/Charts) - Multi-library chart package to create interactive charts
* [Lavacharts](https://github.com/kevinkhill/lavacharts) - Charts and Graphs for PHP Powered by the Google Chart API
* [Eloquent Filter](https://github.com/Tucker-Eric/EloquentFilter) - Filter models and their Relationships
* [Eloquent Sluggable](https://github.com/cviebrock/eloquent-sluggable) - Create slugs for Eloquent models
* [Eloquent Sortable](https://github.com/spatie/eloquent-sortable) - Sortable behaviour for Eloquent models
* [HTML](https://github.com/LaravelCollective/html) - HTML and Form Builders for Laravel
* [Multi-tenant](https://github.com/hyn/multi-tenant) - Flexible multi tenancy with secure separation of routes, assets and databases
* [Laravel Form Builder](https://github.com/kristijanhusak/laravel-form-builder) - Form builder inspired by Symfony's form builder
* [Laravel Activitylog](https://github.com/spatie/laravel-activitylog) - Log activity inside your Laravel app
* [Laravel Auditing](https://github.com/owen-it/laravel-auditing) - Audit for Eloquent models
* [Laravel Breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs) - Create and manage breadcrumbs
* [Laravel Collection Macros](https://github.com/spatie/laravel-collection-macros) - A set of handy collection macros
* [Laravel Cookie Consent](https://github.com/spatie/laravel-cookie-consent) - Make your Laravel app comply with the crazy EU cookie law
* [Laravel Datatables](https://github.com/yajra/laravel-datatables) - jQuery DataTables API
* [Laravel GeoIP](https://github.com/Torann/laravel-geoip) - Determine the location of website visitors based on their IP addresses
* [Laravel Hashids](https://github.com/vinkla/laravel-hashids) - Generate unique, non-sequential ids using [Hashids](http://hashids.org/php/)
* [Laravel Impersonate](https://github.com/404labfr/laravel-impersonate) - A package to authenticate as one of your users
* [Laravel Mailbox](https://github.com/beyondcode/laravel-mailbox) - A package to handle incoming emails
* [Laravel Markdown](https://github.com/GrahamCampbell/Laravel-Markdown) - CommonMark markdown parser
* [Laravel Menu](https://github.com/spatie/laravel-menu) - Html menu generator for Laravel
* [Laravel Talk](https://github.com/nahid/talk) - Realtime User messaging system
* [Laravel Messenger](https://github.com/cmgmyr/laravel-messenger) - User messaging system
* [Laravel Moderation](https://github.com/hootlex/laravel-moderation) - Approve or reject resources like posts, comments, users, etc.
* [Laravel Tags](https://github.com/spatie/laravel-tags) - Add tags and taggable behaviour
* [Laravel Stats Tracker](https://github.com/antonioribeiro/tracker) - Gather information from requests to identify and store
* [Listify](https://github.com/lookitsatravis/listify) - Add sorting/ordering capabilities to any Eloquent model
* [noCAPTCHA](https://github.com/ARCANEDEV/noCAPTCHA) - Helper for Google's new noCAPTCHA (reCAPTCHA)
* [Purifier](https://github.com/mewebstudio/purifier) - HTML filter
* [Revisionable](https://github.com/VentureCraft/revisionable) - Create a revision history for Eloquent models
* [SEOTools](https://github.com/artesaos/seotools) - Helpers for some common SEO techniques
* [Page Cache](https://github.com/JosephSilber/page-cache) - Caches responses as static files on disk for lightning fast page loads
* [Laravel Setting](https://github.com/anlutro/laravel-settings) - Persistent configuration settings that are stored in JSON files
* [Friendship](https://github.com/hootlex/laravel-friendships) - Friendship management system
* [Teamwork](https://github.com/mpociot/teamwork) - User to team associations with an invite system
* [Validating](https://github.com/dwightwatson/validating) - Trait for validating Eloquent models
* [VAT Calculator](https://github.com/mpociot/vat-calculator) - Handle all the hard stuff related to EU MOSS vat regulations
* [Laravel UUID](https://github.com/webpatser/laravel-uuid) - Generate a UUID according to the RFC 4122 standard
* [Laravel Installer](https://github.com/RachidLaasri/LaravelInstaller) - Allow users to install your application just by following the setup wizard, like WordPress
* [Laravel Modules](https://github.com/nWidart/laravel-modules) - Easy module management
* [Laravel Phone](https://github.com/Propaganistas/Laravel-Phone) - Phone number validator and formatter
* [Laravel Ban](https://github.com/cybercog/laravel-ban) - Simplify blocking and banning Eloquent models
* [Laravel Proxy](https://github.com/fideloper/TrustedProxy) - Handling sessions when behind load balancers or other intermediaries.
* [Laravel Video Chat](https://github.com/PHPJunior/laravel-video-chat) - Video Chat using Socket.IO and WebRTC
* [Widgets for Laravel](https://github.com/arrilot/laravel-widgets) - A powerful alternative to view composers.
* [Secure Headers](https://github.com/BePsvPT/secure-headers) - Add security related headers to HTTP response
* [Laravel Nova](https://nova.laravel.com/) - Nova is a beautifully designed administration panel for Laravel
* [Laravel Love](https://github.com/cybercog/laravel-love) - It lets people express how they feel about the content. React on Eloquent models with Likes or Dislikes.
* [stancl/tenancy](https://github.com/stancl/tenancy) - Automatic tenancy for your Laravel app. No code changes needed.

##### Media & Document Management

* [Intervention Image](https://github.com/Intervention/image) - Image handling library for creating, editing and composing images
* [Laravel ImageUp](https://github.com/qcod/laravel-imageup) - Yet another image manipulation package, adds tons of extra functionality
* [Laravel Glide](https://github.com/spatie/laravel-glide) - Easily convert images with Glide
* [Laravel MediaLibrary](https://github.com/spatie/laravel-medialibrary) - Associate files with Eloquent models
* [Laravel Snappy](https://github.com/barryvdh/laravel-snappy) - HTML to PDF generator using wkhtmltopdf
* [Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf) - HTML to PDF generator using [dompdf](https://github.com/dompdf/dompdf)
* [Laravel Stapler](https://github.com/CodeSleeve/laravel-stapler) - ORM-based file upload manager
* [Laravel Excel](https://github.com/Maatwebsite/Laravel-Excel) - Import and export Excel and CSV files
* [Fast Excel](https://github.com/rap2hpoutre/fast-excel) - Fast XLSX, CSV and ODT import and export for Laravel
* [Laravolt Avatar](https://github.com/laravolt/avatar) - Plug n play avatar, turn name, email, and any other string into beautiful avatar (or gravatar), effortless.
* [Laravel FFmpeg](https://github.com/pascalbaljetmedia/laravel-ffmpeg) - This package provides an integration with FFmpeg for Laravel 5.8.

##### Integration with Javascript

* [Laroute](https://github.com/aaronlord/laroute) - Generate Laravel route URLs from JavaScript
* [PHP Vars to JavaScript Transformer](https://github.com/laracasts/PHP-Vars-To-Js-Transformer) - Pass server-side string/array/collection/whatever to JavaScript
* [Javascript Validation](https://github.com/proengsoft/laravel-jsvalidation) - Use validation rules, messages, FormRequest and validators to validate forms in client-side
* [Laravel Pjax](https://github.com/spatie/laravel-pjax) - A Pjax middleware
* [Laravel Blade Javascript](https://github.com/spatie/laravel-blade-javascript) - A Blade directive to export variables to JavaScript
* [Ziggy](https://github.com/tightenco/ziggy) - Use your Laravel named routes in JavaScript
* [LiveWire](https://github.com/livewire/livewire) - A magical front-end framework for Laravel

##### Databases, ORMs, Migrations & Seeding

* [Backup Manager](https://github.com/backup-manager/laravel) - Backup and restore databases from S3, Dropbox, SFTP etc.
* [Laravel Nestedset](https://github.com/lazychaser/laravel-nestedset) - Nested Sets pattern implementation
* [ClosureTable](https://github.com/franzose/ClosureTable) - Closure table pattern implementation
* [Eloquence](https://github.com/kirkbushell/eloquence) - Extra features for Eloquent models
* [iSeed](https://github.com/orangehill/iseed) - Generate a new seed file from an existing database table
* [Laravel OCI8](https://github.com/yajra/laravel-oci8) - Oracle DB driver via OCI8
* [Laravel Backup](https://github.com/spatie/laravel-backup) - Backup your app
* [Laravel Doctrine](https://github.com/laravel-doctrine/orm) - Doctrine 2 ORM implementation
* [Laravel MongoDB](https://github.com/jenssegers/laravel-mongodb) - Eloquent model and query builder with support for MongoDB
* [Migrations Generator](https://github.com/Xethron/migrations-generator) - Generate migrations from an existing database
* [Sofa/Eloquence](https://github.com/jarektkaczyk/eloquence) - Extensions for the Eloquent ORM
* [Tenanti](https://github.com/orchestral/tenanti) - Multi-tenant database schema manager
* [Laravel Repository](https://github.com/andersao/l5-repository) - Repositories to abstract the database layer
* [Lada Cache](https://github.com/spiritix/lada-cache) - A Redis based, fully automated and scalable database cache layer
* [Laravel MySQL Spatial extension](https://github.com/grimzy/laravel-mysql-spatial) - easily work with MySQL Spatial Data Types and MySQL Spatial Functions

##### Search

* [Algolia Search](https://github.com/algolia/algoliasearch-laravel) - Integrates the Algolia Search API to the Laravel Eloquent ORM
* [Elasticquent](https://github.com/elasticquent/Elasticquent) - Elasticsearch for Eloquent models
* [Plastic](https://github.com/sleimanx2/plastic) - Fluently mapping and searching Elasticsearch
* [Laravel Search](https://github.com/mmanos/laravel-search) - Unified API for Elasticsearch, Algolia, and ZendSearch
* [SearchIndex](https://github.com/spatie/searchindex) - Store and retrieve objects from Algolia or Elasticsearch
* [Searchable](https://github.com/nicolaslopezj/searchable) - Trait that adds a simple search function to Eloquent models
* [TNTSearch](https://github.com/teamtnt/tntsearch) - A fully featured full text search engine written in PHP
* [TNTSearch driver](https://github.com/teamtnt/laravel-scout-tntsearch-driver) - Driver for [Laravel Scout](https://github.com/laravel/scout) search package based on TNTSearch
* [Laravel-Searchy](https://github.com/TomLingham/Laravel-Searchy) - Fuzzy search, basic string matching, Levenshtein Distance

##### APIs

* [ApiGuard](https://github.com/chrisbjr/api-guard) - Allow API authentication with API keys
* [Dingo API](https://github.com/dingo/api) - Multi-purpose toolkit for developing RESTful APIs
* [Laravel CORS](https://github.com/barryvdh/laravel-cors) - Add CORS (Cross-Origin Resource Sharing) headers support
* [Laravel Fractal](https://github.com/spatie/laravel-fractal) - Output complex, flexible, AJAX/RESTful data structures with Fractal
* [Laravel GraphQL](https://github.com/rebing/graphql-laravel) - Supports Relay, eloquent models, validation and GraphiQL
* [Lighthouse](https://github.com/nuwave/lighthouse) - An up and coming GraphQL library for Laravel
* [Laravel Responder](https://github.com/flugger/laravel-responder) - Build custom API responses with Fractal

##### Tasks, Commands and Scheduling

* [Dispatcher](https://github.com/indatus/dispatcher) - Scheduler for Artisan commands
* [Elixir](https://github.com/laravel/elixir) - Node (NPM) package to run Gulp tasks
* [Mix](https://github.com/JeffreyWay/laravel-mix) - Fluent API for defining basic webpack build steps
* [Envoy](https://github.com/laravel/envoy) - SSH Task Runner

##### Payments

* [Cashier](https://github.com/laravel/cashier) - Subscription billing with Stripe
* [Omnipay for Laravel](https://github.com/ignited/laravel-omnipay) - Integrate the [Omnipay](https://github.com/thephpleague/omnipay) PHP library

##### Optimization

* [Intervention Image Cache](https://github.com/Intervention/imagecache) - Caching extension for the Intervention Image Class
* [Laravel HTMLMin](https://github.com/GrahamCampbell/Laravel-HTMLMin) - Blade/HTML/CSS/javascript minifier
* [Rememberable](https://github.com/dwightwatson/rememberable) - Query caching for Eloquent
* [Widgetize](https://github.com/imanghafoori1/laravel-widgetize) - Page Partial caching
* [Laravel Responsecache](https://github.com/spatie/laravel-responsecache) - Speed up app by caching the entire response

##### Monitoring

* [Horizon](https://github.com/laravel/horizon) - Monitor and configure queues with a simple web UI
* [Laravel Failed Job Monitor](https://github.com/spatie/laravel-failed-job-monitor) - Get notified when a queued job fails
* [Laravel Uptime Monitor](https://github.com/spatie/laravel-uptime-monitor) - A powerful and easy to configure uptime and ssl monitor
* [Larametrics](https://github.com/aschmelyun/larametrics) - A self-hosted metrics and notifications platform for Laravel apps

##### Localization

* [Language Files](https://github.com/caouecs/Laravel-lang) - Validation, Pagination and Reminders language lines in 37 languages
* [Laravel Localization](https://github.com/mcamara/laravel-localization) - Add i18n support via routes
* [Laravel Translatable](https://github.com/spatie/laravel-translatable) - Making Eloquent models translatable by storing translations as JSON
* [Laravel Translatable](https://github.com/dimsav/laravel-translatable) - Retrieve and store translatable Eloquent model instances
* [Laravel Translator](https://github.com/vinkla/laravel-translator) - Translate Eloquent models into multiple languages
* [Laravel Date](https://github.com/jenssegers/date) - A library to help you work with dates in multiple languages, based on Carbon
* [Laravel Langman](https://github.com/themsaid/laravel-langman) - Manage language files from Artisan Console
* [Laravel Translation](https://github.com/waavi/translation) - Translation and localization management
* [Linguist](https://github.com/keevitaja/linguist) - i18n localization support for Laravel

##### Third-party Service Integration

* [Laravel Analytics](https://github.com/spatie/laravel-analytics) - Retrieve pageviews and other data from Google Analytics
* [Laravel DigitalOcean](https://github.com/GrahamCampbell/Laravel-DigitalOcean) - DigitalOceanV2 bridge
* [Laravel GitHub](https://github.com/GrahamCampbell/Laravel-GitHub) - PHP GitHub API bridge
* [Laravel Instagram](https://github.com/vinkla/laravel-instagram) - Instagram API bridge
* [Laravel Newsletter](https://github.com/spatie/laravel-newsletter) - Send newsletters with Mailchimp
* [Laravel Pusher](https://github.com/vinkla/laravel-pusher) - Pusher API bridge

## Development Setup

* [Homestead](https://laravel.com/docs/master/homestead) - Official Vagrant box for Laravel
* [Valet](https://laravel.com/docs/master/valet) - Development environment for Mac users
* [Valet Linux](https://github.com/cpriego/valet-linux) - Development environment for Linux users
* [LaraDock](https://github.com/LaraDock/laradock) - Run Laravel on Docker (Like Homestead but for Docker instead of Vagrant)
* [LaraEdit Docker](https://github.com/laraedit/laraedit-docker) - Homestead environment in a single Docker container
* [Laragon](https://laragon.org/) -  Isolated development environment on Windows
* [Stacker](https://github.com/Maxlab/stacker) - The environment for local web development on Docker
* [Devilbox](https://github.com/cytopia/devilbox) - A dockerized and general-purpose LAMP/MEAN stack for every PHP version
* [Vessel](https://vessel.shippingdocker.com) - Simple Docker development environments for Laravel
* [Lando](https://docs.lando.dev/config/laravel.html) - A local development environment tool built on Docker

## Application Hosting

* [Vapor](https://vapor.laravel.com)
* [Forge](https://forge.laravel.com/) ([ForgeRecipes](https://forgerecipes.com/))
* [FortRabbit](https://www.fortrabbit.com/laravel-hosting)
* [Heroku](https://www.heroku.com/) ([Documentation](https://devcenter.heroku.com/articles/getting-started-with-laravel))
* [AWS Elastic Beanstalk](https://aws.amazon.com/elasticbeanstalk/) ([Tutorial](http://docs.aws.amazon.com/elasticbeanstalk/latest/dg/php-laravel-tutorial.html))
* [Cloudways](https://www.cloudways.com/en/laravel-hosting.php)
* [Ploi](https://ploi.io/)
* [CodePier](https://codepier.io?ref=awesome-laravel)
* [RunCloud](https://runcloud.io/)

## Application Deployment

* [Deployer](https://deployer.org/) - A deployment tool with support for Laravel out of the box
* [Envoyer](https://envoyer.io/) - Zero down-time Deployer for PHP & Laravel projects
* [Rocketeer](https://github.com/rocketeers/rocketeer) - Task runner and deployment package

## Code Snippets

* [Laravel LTS Cheat Sheet ](https://summerblue.github.io/laravel5-cheatsheet/) ([Chinese version](https://cs.phphub.org/))
* [Laravel Tricks](http://laravel-tricks.com/)

## Tutorials & Blogs

* [Taylor Otwell](http://taylorotwell.com/)
* [Tuts+](https://code.tutsplus.com/categories/laravel)
* [Medium](https://medium.com/tag/laravel/latest)
* [Laravel Daily](https://laraveldaily.com/)
* [Scotch](https://scotch.io/tag/laravel)
* [Digital Ocean](https://www.digitalocean.com/community/search?q=laravel&primary_filter=newest&type=tutorials)
* [Matt Stauffer](https://mattstauffer.co/blog)
* [Vegi Bit](https://vegibit.com/tag/laravel/)
* [Neon Tsunami](https://www.neontsunami.com/tags/laravel)
* [Dor.ky](https://dor.ky/tag/laravel/)
* [Stillat](https://stillat.com/explore/categories/laravel-5)
* [Easy Laravel Book Blog](http://www.easylaravelbook.com/blog/)
* [Laraveles](http://laraveles.com/blog/) (ES)
* [Styde](https://styde.net/category/laravel-5/) (ES)
* [Cloudways Laravel Blog](http://cloudways.com/blog/laravel)
* [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
* [Pusher Laravel Tutorials](https://pusher.com/tutorials?tag=Laravel)
* [LaraShout](https://larashout.com/)

## Videos

* [Laracasts](https://laracasts.com/)
* [Codecourse](https://www.codecourse.com/) ([YouTube](https://www.youtube.com/user/phpacademy/playlists))
* [Tuts+](http://code.tutsplus.com/categories/laravel/courses)
* [Servers for Hackers](https://serversforhackers.com/laravel-perf)
* [Test-Driven Laravel](https://course.testdrivenlaravel.com/)
* [Duilio Palacios](https://www.youtube.com/user/silencedsg/videos) (ES)
* [CodigoFacilito](https://codigofacilito.com/courses/laravel) (ES)
* [DevDojo](https://devdojo.com/search?value=laravel)
* [Amitav Roy](https://www.youtube.com/channel/UC4gijXR8cM4gmEt9Olse-TQ/videos)
* [Laracademy](https://laracademy.co/)
* [Dev Marketer](https://www.youtube.com/channel/UC6kwT7-jjZHHF1s7vCfg2CA/playlists)
* [Udemy](https://www.udemy.com/courses/search/?q=laravel)
* [Lynda](https://www.lynda.com/search?q=laravel)
* [Pluralsight](https://www.pluralsight.com/search?q=laravel&categories=course)
* [Bitfumes](https://www.youtube.com/bitfumes)
* [ConfidentLaravel](https://confidentlaravel.com/)

## Conferences

* [Laracon US](http://laracon.us/)
* [Laracon EU](http://laracon.eu/)
* [Laracon Online](https://laracon.net/)
* [Laraconf Brasil](http://laraconfbrasil.com.br/)
* [Laracon Australia](https://laracon.com.au/)
* [Laravel Live UK](https://laravellive.uk/)
* [Laravel Live India](https://laravellive.in/)
* [Laravel Nigeria](https://laravelnigeria.com)

##### Videos

* [Laracon EU 2018](https://www.youtube.com/playlist?list=PLMdXHJK-lGoC64wnqvm6v1R5dsuAV-MpS)
* [Laracon US 2018](https://www.youtube.com/playlist?list=PL-yJve--iT5oM2LgF37VXsBb8Os4ZulIc)
* [Laracon EU 2017](https://www.youtube.com/playlist?list=PLMdXHJK-lGoBFZgG2juDXF6LiikpQeLx2)
* [Laracon US 2017](https://www.youtube.com/playlist?list=PL-yJve--iT5oaLQA6OI8TWLVSOBP1qhs3)
* [Laracon EU 2016](https://www.youtube.com/playlist?list=PLMdXHJK-lGoCMkOxqe82hOC8tgthqhHCN)
* [Laracon US 2016](https://www.youtube.com/playlist?list=PL-yJve--iT5o9fH_cRY0u6P751pcF59GK)
* [Laracon EU 2015](https://www.youtube.com/playlist?list=PLMdXHJK-lGoA9SIsuFy0UWL8PZD1G3YFZ)
* Laracon US 2015
* [Laracon EU 2014](https://www.youtube.com/playlist?list=PLMdXHJK-lGoCYhxlU3OJ5bOGhcKtDMkcN)
* [Laracon US 2014](https://www.youtube.com/channel/UCRawXmZv30Vf_MivyPYb_GQ/videos)
* [Laracon EU 2013](https://www.youtube.com/playlist?list=PLMdXHJK-lGoB-CIVsiQt0WU8WcYrb5eoe)
* [Laracon US 2013](https://www.youtube.com/playlist?list=PLkwAlZpjHQbLcox_S_AgGU24QUfKgXayN)

## Books

* [Laravel Starter](https://www.amazon.com/Laravel-Starter-Shawn-McCool-ebook/dp/B00ABFQ0AS) by Shawn McCool
* [Laravel: Code Happy](https://leanpub.com/codehappy) by Dayle Rees
* [Laravel: Code Bright](https://leanpub.com/codebright) by Dayle Rees
* [Laravel: Code Smart](https://leanpub.com/codesmart) by Dayle Rees
* [Laravel: From Apprentice To Artisan](https://leanpub.com/laravel) by Taylor Otwell
* [Laravel 4 Cookbook](https://leanpub.com/laravel4cookbook) by Christopher Pitt and Taylor Otwell
* [Laravel Testing Decoded](https://leanpub.com/laravel-testing-decoded) by Jeffrey Way
* [Refactoring to Collections](https://adamwathan.me/refactoring-to-collections/) by Adam Wathan
* [Implementing Laravel](https://leanpub.com/implementinglaravel) by Chris Fidao
* [Getting Stuff Done with Laravel 4](https://leanpub.com/gettingstuffdonelaravel) by Chuck Heintzelman
* [Laravel Application Development Blueprints](https://www.packtpub.com/web-development/laravel-application-development-blueprints) by Arda Kılıçdağı and Halil İbrahim Yılmaz
* [Build APIs You Won't Hate](https://leanpub.com/build-apis-you-wont-hate) by Phil Sturgeon
* [Integrating Front end Components with Web Applications](https://leanpub.com/frontend) by Maksim Surguy
* [Laravel Design Patterns and Best Practices](https://www.packtpub.com/web-development/laravel-design-patterns-and-best-practices) by Arda Kılıçdağı and Halil İbrahim Yılmaz
* [Learning Laravel 4 Application Development](https://www.packtpub.com/web-development/learning-laravel-4-application-development) by Hardik Dangar
* [Getting Started with Laravel 4](https://www.packtpub.com/web-development/getting-started-laravel-4) by Raphaël Saunier
* [Laravel Application Development Cookbook](https://www.packtpub.com/web-development/laravel-application-development-cookbook) by Terry Matula
* [Building Web Applications Using Parse REST API](https://leanpub.com/building-web-applications-using-parse-rest-api) by Mhd Zaher Ghaibeh
* [Laravel - My First Framework](https://leanpub.com/laravel-first-framework) by Maksim Surguy
* [Easy Laravel 5](https://leanpub.com/easylaravel/) by W. Jason Gilmore
* [Laravel 5 Essentials](https://www.packtpub.com/web-development/laravel-5-essentials) by Martin Bean
* [Easy E-Commerce Using Laravel and Stripe](https://leanpub.com/easyecommerce) by W. Jason Gilmore and Eric L. Barnes
* [Laravel 5.1 Beauty](https://leanpub.com/l5-beauty) by Chuck Heintzelman
* [Design Patterns with PHP and Laravel](https://leanpub.com/larasign) by Kelt Dockins
* [Mastering Laravel](https://www.packtpub.com/web-development/mastering-laravel) by Christopher John Pecoraro
* [How to Build Real-Time Laravel Apps with Pusher](http://pusher-community.github.io/real-time-laravel/) by Pusher
* [Learning Laravel's Eloquent](https://www.amazon.com/Learning-Laravels-Eloquent-Francesco-Malatesta-ebook/dp/B00YSILQ6C) by Francesco Malatesta
* [Laravel 5 Learn Easy](https://leanpub.com/laravel5learneasy) by Sanjib Sinha
* [Laravel and AngularJS](https://leanpub.com/laravel-and-angularjs) by Daniel Schmitz and Daniel Pedrinha Georgii
* [Laravel Collections Unraveled](https://leanpub.com/laravelcollectionsunraveled) by Jeff Madsen
* [Writing APIs With Lumen](https://leanpub.com/lumen-apis) by Paul Redmond
* [The Laravel Survival Guide](https://leanpub.com/laravelsurvivalguide) by Tony Lea
* [Laraboot: Laravel 5 For Beginners](https://leanpub.com/laravel-5-for-beginners-laraboot) by Bill Keck
* [Laravel 5.4 For Beginners](https://leanpub.com/laravel-5-4-for-beginners) by Bill Keck
* [Laravel Up & Running](https://www.amazon.com/gp/product/1491936088) by Matt Stauffer
* [Laravel Companion](https://leanpub.com/laravelcompanion-secondedition) by Johnathon Koster
* [Deploy Laravel on AWS with CloudFormation](https://leanpub.com/laravel-aws) by Lionel Martin
* [React Native and Laravel for Future Mobile Development](https://leanpub.com/rn_laravel) by Ega Radiegtya
* [Servers for Hackers](https://book.serversforhackers.com) by Chris Fidao
* [Full-Stack Vue.js 2 and Laravel 5](https://www.amazon.com/Full-Stack-Vue-js-Laravel-frontend-together/dp/1788299582) by Anthony Gore
* [Build an API with Laravel](https://buildanapi.com) by Wacky Studio

## Starter Projects

* [Spark](https://spark.laravel.com/)
* [LaraAdmin](https://github.com/dwijitsolutions/laraadmin)
* [Grafite Builder](https://github.com/GrafiteInc/Builder)
* [Laravel Boilerplate](https://github.com/rappasoft/laravel-5-boilerplate)
* [Laravel Angular Material Starter](https://github.com/jadjoubran/laravel5-angular-material-starter)
* [AdminLTE Laravel](https://github.com/acacha/adminlte-laravel)
* [Laravel Hackathon Starter](https://github.com/unicodeveloper/laravel-hackathon-starter)
* [Laravel API Starter Kit](https://github.com/joselfonseca/laravel-api)
* [Backpack for Laravel](https://github.com/Laravel-Backpack/Base)
* [SomelineStarter](https://github.com/someline/someline-starter)
* [Laravel Admin](https://github.com/z-song/laravel-admin)
* [Voyager](https://github.com/the-control-group/voyager)
* [Orchid](https://github.com/TheOrchid/Platform)
* [Laravel REST API Boilerplate](https://github.com/francescomalatesta/laravel-api-boilerplate-jwt)
* [Hello API](https://github.com/Porto-SAP/Hello-API)
* [REST API With Lumen](https://github.com/hasib32/rest-api-with-lumen)
* [Laravel Zero - Console application](https://github.com/laravel-zero/laravel-zero)
* [Apiato](https://github.com/apiato/apiato)
* [Laravel Adminpanel](https://github.com/viralsolani/laravel-adminpanel)
* [Laravel Vue Boilerplate](https://github.com/alefesouza/laravel-vue-boilerplate)
* [Laravel Enso](https://github.com/laravel-enso/enso)
* [Laravel Template with Vue](https://github.com/wmhello/laravel_template_with_vue)

## Codebases for Reference

* [Cachet](https://github.com/cachethq/Cachet) - Status page system for websites and APIs
* [Deployer](https://github.com/REBELinBLUE/deployer) - Application deployment system
* [GitScrum](https://github.com/renatomarinho/laravel-gitscrum) - Task management with Git and Scrum
* [Invoice Ninja](https://github.com/invoiceninja/invoiceninja) - Invoicing, expenses, & time-tracking application
* [Koel](https://github.com/phanan/koel) - Personal music streaming server
* [Laravel.io](https://github.com/laravelio/portal) - Source for the Laravel.io Community Portal
* [Attendize](https://github.com/Attendize/Attendize) - Ticket selling and event management platform
* [Antvel](https://github.com/ant-vel/App) - Ecommerce platform
* [Jigsaw](https://github.com/tightenco/jigsaw) - Static site generator
* [Canvas](https://github.com/cnvs/canvas) - A Laravel Publishing Platform
* [Vuedo](https://github.com/Vuedo/vuedo) - Vuedo is blog platform, built with Laravel and Vue.js
* [Screeenly](https://github.com/stefanzweifel/screeenly) - Create website screenshots through an API
* [Voten](https://github.com/voten-co/voten) - A real-time social bookmarking for the 21st century
* [Monica](https://github.com/monicahq/monica) - Personal relationship management system
* [Snipe-IT](https://github.com/snipe/snipe-it) - IT asset/license management system
* [Akaunting](https://github.com/akaunting/akaunting) - Accounting software for small businesses and freelancers
* [Torch](https://github.com/mattstauffer/Torch) - Examples of using each Illuminate component in non-Laravel applications
* [Pixelfed](https://github.com/pixelfed/pixelfed) - A free and ethical photo sharing platform, powered by ActivityPub federation


## Content Management Systems

* [OctoberCMS](https://github.com/octobercms/october)
* [SleepingOwlAdmin](https://github.com/LaravelRUS/SleepingOwlAdmin)
* [PyroCMS](https://github.com/pyrocms/pyrocms)
* [Lavalite](https://github.com/LavaLite/cms)
* [TypiCMS](https://github.com/typicms/base)
* [Asgard CMS](https://github.com/AsgardCms/Platform)
* [Microweber](https://github.com/microweber/microweber)
* [Coaster CMS](https://github.com/web-feet/coastercms)
* [Statamic](https://statamic.com/)
* [Borgert CMS](https://github.com/odirleiborgert/borgert-cms/)
* [PJ Blog](https://github.com/jcc/blog/)
* [Laralum](https://github.com/Laralum/Laralum)
* [Twill](https://github.com/area17/twill)

## Podcasts

* [The Laravel Podcast](http://www.laravelpodcast.com/)
* [The Laravel News Podcast](https://laravel-news.com/podcast/ )
* [The Laracasts Snippet](https://laracasts.simplecast.fm/)
* [Hecho en Laravel (Spanish)](http://hechoenlaravel.com)

## Community

* [Laracasts Forum](https://laracasts.com/discuss)
* [Laravel.io Forum](http://laravel.io/forum)
* [Larachat Slack](https://larachat.slack.com/) ([Signup](https://larachat.co/register))
* [Gitter](https://gitter.im/laravel/laravel)
* [IRC Channel](http://laravel.io/chat)
* [StackOverflow](http://stackoverflow.com/questions/tagged/laravel)
* [Twitter](https://twitter.com/laravelphp)
* [Google+](https://plus.google.com/communities/106838454910116161868)
* [Reddit](https://www.reddit.com/r/laravel)
* [Quora](https://www.quora.com/topic/Laravel)
* [Facebook](https://www.facebook.com/LaravelCommunity)
* [LinkedIn](https://www.linkedin.com/groups/4419933/profile)

##### Local User Groups

* [Laravel Global Community](https://www.facebook.com/groups/group.laravel/)
* [LaravelES Slack](https://laraveles.slack.com) ([Signup](http://laraveles.com/blog/wp-login.php?action=slack-invitation))
* [Laravel India](https://laravellive.in/), [Slack Signup](https://laravelliveindia.slack.com/join/shared_invite/enQtNjQyMDE4NDA3MDQzLWMyZmIxNGZkNGVkNGFmMzE1MTgyOGNiZGY1ZmU1ZDQ3Mzk2ODBlZGJlODk3ZmI0OWNlZmI5MzQyZDJhYzg1NjE), [Twitter](https://twitter.com/LaravelLiveIN), [Facebook](https://www.facebook.com/laravellive/), [Youtube](https://www.youtube.com/channel/UC6TxYSHI7g9FMJ7VlHk72Yg)
* [Laravel UK](https://laravelphp.uk/), [Slack Signup](https://laravelphp.uk/login/slack)
* [Laravel Russia](https://laravel.ru/) ([VK group](http://m.vk.com/laravel_rus))
* [Laravel France](https://laravel.fr/)
* [Laravel Bangladesh](https://www.facebook.com/groups/LaravelBanglaDesh/)
* [Laravel Indonesia](http://id-laravel.com/) ([Facebook](https://www.facebook.com/groups/laravel/), [Telegram](https://t.me/laravelindonesia))
* [Laravel Brasil](http://www.laravel.com.br/) ([Facebook](https://www.facebook.com/groups/laravelbrasil/), [Slack](http://slack.laravel.com.br), [Telegram](https://telegram.me/laravelbr), [GitHub](https://github.com/laravelbrasil), [Discord](https://discord.gg/9dpuWeZ))
* [Laravel Turkey](http://www.laravel.gen.tr/) ([Facebook](https://www.facebook.com/groups/laravelturkiye/))
* [Laravel Nigeria](http://www.laravelnigeria.com/) ([Facebook](https://www.facebook.com/groups/laravelnigeria/))
* [Laravel China](https://phphub.org/)
* [Laravel Taiwan](https://laravel.tw/) ([Facebook](https://www.facebook.com/groups/laravel.tw/))
* [Laravel Spanish](http://laraveles.com/foro/)
* [Laravel Korea](https://www.laravel.co.kr/) ([Facebook](https://www.facebook.com/groups/laravelkorea/))
* [Laravel Japan](http://laravel.jp/) ([Facebook](https://www.facebook.com/groups/laravel.jp/))
* [Laravel Malaysia](https://www.facebook.com/groups/laravel.my/)
* [Laravel Algeria](https://www.facebook.com/groups/LaravelAlgeria/)
* [Laravel Greece](http://www.laravel.gr) ([Facebook](https://www.facebook.com/laravelgr))
* [Laravel Middle East](http://laravelme.com/) ([Facebook](https://www.facebook.com/laravelme))
* [Laravel Georgia](https://www.facebook.com/groups/laravel.georgia/)
* [Laravel Italy](http://laravel-italia.it)
* [Laravel Vietnam](https://www.facebook.com/groups/vietnam.laravel/)
* [Laravel Slovenia](https://www.facebook.com/groups/laravelslovenija/)
* [Laravel Hungary](https://laravel.hu)
* [Laravel Cameroon](https://laravelcm.com/) ([Slack](https://laravelcm.slack.com), [GitHub](https://github.com/laravelcm), [Facebook](https://www.facebook.com/laravelcm), [Twitter](https://twitter.com/laravelcm))
* [Laravel Philippines](https://www.facebook.com/groups/laravelph)
* [Laravel DRC](https://laravelcd.com/) ([Slack](https://laravelcd.slack.com), [GitHub](https://github.com/laravelcd), [Facebook](https://www.facebook.com/laravelcd), [Twitter](https://twitter.com/laravelcd))

##### Meetups

* [All Meetups](http://www.meetup.com/topics/laravel/)
* [London Meetup](https://www.meetup.com/London-Laravel/)
* [Buenos Aires Meetup](https://www.meetup.com/Laravel-Buenos-Aires/)
* [Athens-Greece Meetup](https://www.meetup.com/athens-laravel-meetup/)
* [Copenhagen Meetup](https://www.meetup.com/Copenhagen-Laravel-Meetup/)
* [Detroit Meetup](https://www.meetup.com/Laravel-Detroit/)
* [Paris Meetup](https://www.meetup.com/fr-FR/Paris-Laravel-Meetup/)
* [Melbourne Meetup](https://www.meetup.com/Melbourne-laravel-Meetup/)
* [Budapest Meetup](https://www.meetup.com/Laravel-Hungary-Meetup/)

## Jobs

* [LaraJobs](https://larajobs.com/)
* [Laravel Gurus](https://laravelgurus.com/)

## Hosted Development Tools

* [Laravel Shift](https://laravelshift.com/) - Automated upgrade tool for Laravel projects
* [Laravel Schema Designer](http://laravelsd.com/) - Create, export and share database schemas
* [StyleCI](https://styleci.io) - PHP Coding Style Service

## Miscellaneous

* [CodeCanyon](https://codecanyon.net/tags/laravel?term=laravel) - Paid scripts and plugins
* [Laravel Collections](https://laravelcollections.com) - Every Laravel Developers Goto Resource Site
* [LaravelLinks](https://telegram.me/laravellinks) - A Telegram Channel dedicated to sharing great Laravel Resources

## Contributing

Found an awesome package, blog, course or video? Send me a pull request!

#### Guidelines

* Please make an individual pull request for each suggestion
* Make sure the Travis tests pass on your pull request
* Use the following format for links: \[Resource\]\(URL\)
* Want to suggest a package? Read the [Contribution Guide](https://github.com/chiraggude/awesome-laravel/blob/master/CONTRIBUTING.md)
* New categories or improvements to the existing categorization are welcome

## License

[![CC BY 4.0](https://licensebuttons.net/l/by/4.0/88x31.png)](https://creativecommons.org/licenses/by/4.0/)

Awesome Laravel is licensed under a  [Creative Commons Attribution 4.0 International License](https://creativecommons.org/licenses/by/4.0/).
            ",
            'published_at' => now()->addDay(),
            'submitted_at' => now()->addDay()->subHour(),
            'approved_at' => now()->addDay()->addHours(2),
            'show_toc' => true,
            'canonical_url' => null,
            'user_id' => (int) array_rand($usersIds),
        ]);
        $article4->syncTags(array_rand($tagsIds, 3));
        $article4->addMediaFromUrl("https://unsplash.it/1920/1080?random={$article4->id}")
            ->toMediaCollection('media');

        /** @var Article $article5 */
        $article5 = Article::query()->create([
            'title' => $name = 'COVID TEST CENTER',
            'slug' => $name,
            'body' => "

Android Application + Web Server Development

by Guillaume Sherpa and Vivien Debuchy

Students of Mines St Etienne, ISMIN 2020 - M2 Computer Science.

[![Mines St Etienne](./logo.png)](https://www.mines-stetienne.fr/)

---
### Project

This application allows to list and display all covid test centers in France.

Database of centers from [www.data.gouv.fr](https://www.data.gouv.fr/fr/datasets/sites-de-prelevements-pour-les-tests-covid/), downloaded on a [clevercloud server](covidtesingcenter-app.cleverapps.io).

### Features
- Access all French COVID test centers ✔️
- Bookmark centers ✔️
- Check detailed center information ✔️
- Refresh data base from server ✔️

### Get started !
- Start Android Studio after downloading the project
- Select `Open an existing Android Studio project` and pick this directory

### Technical information:
-    The App is connected to a remote REST API server (Thanks to clervercould.com for free access to their infrastructure). Data are stored into the remote server in JSON format
-    The App contains two fragments (data list and database information)
-    The App contains two activities (main activity and detail activity)
-    In the data list the “car” icon means that the COVID-19 test is done via a drive and the “place” icon means that the test is done on location
-    It is possible to mark a COVID-19 test center as a favorite. The information is stored is the shared preferences of the Android OS.

---
### Authors' quote

> G/ Tu pourrais le push ?

> V/ Par contre niveau UI mon activité est dégueulasse, c'est froid et impersonnel

> V/ La réduction des données est plus faible que prévue et ça crash toujours

> G/ La solution de facilité serait de réduire le JSON...

> V/ Déjà si on a une base solide, c'est cool !

> V/ Bon du coup, j'ouvre Android studio. Tu en étais ou toi ?

> G/ Bizard normalement, on a le même code, chez moi ça marche...

> G/ Bingo !

> V/ Mais j'habite pas dans le CNRS moi, aled.

### License

MIT
            ",
            'published_at' => now(),
            'submitted_at' => now()->addHours(4),
            'approved_at' => now()->addHours(5),
            'show_toc' => false,
            'canonical_url' => null,
            'user_id' => (int) array_rand($usersIds),
        ]);
        $article5->syncTags(array_rand($tagsIds, 3));
        $article5->addMediaFromUrl("https://unsplash.it/1920/1080?random={$article5->id}")
            ->toMediaCollection('media');

        /** @var Article $article6 */
        $article6 = Article::query()->create([
            'title' => $name = 'Le nouveau site de Grafikart (Grafikart.New)',
            'slug' => $name,
            'body' => "
            Dépôt pour la nouvelle version de Grafikart.fr. L'objectif est de rendre le projet Open Source afin que tout le monde puisse participer à l'élaboration du site et à son évolution.

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

- [Etat d'avancement](#etat-davancement)
- [Participer (faire une PR)](#participer-faire-une-pr)
- [Objectifs, pourquoi une refonte ?](#objectifs-pourquoi-une-refonte-)
  - [Problèmes techniques](#probl%C3%A8mes-techniques)
  - [Problème d'organisation / d'UX](#probl%C3%A8me-dorganisation--dux)
  - [Rendre le code Open Source](#rendre-le-code-open-source)
- [Design](#design)
- [Tips](#tips)
- [Fonts à tester](#fonts-%C3%A0-tester)
- [Référence](#r%C3%A9f%C3%A9rence)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Etat d'avancement

L'avancement peut être suivi sur la [board trello de grafikart](https://trello.com/b/oKnfpVtU/grafikart)

## MR à suivre :

- Erreur dans les logs de PHPUnit : https://github.com/symfony/monolog-bundle/pull/336
- Plusieurs listeners Doctrine ne peuvent pas utiliser la même class : https://github.com/doctrine/DoctrineBundle/issues/1224

## Participer (faire une PR)

Le développement a commencé et vous pouvez récupérer le projet et pour travailler dessus. Afin de simplifier la mise en place de l'environnement de dev, **docker** a été choisi :

```bash
make dev ## Permet de lancer le serveur de développement, accessible ensuite sur http://grafikart.localhost:8000
make seed ## Permet de remplir la base de données
```

Pour les tests vous pouvez lancer une de ces commandes :

```bash
make test ## Permet de lancer les tests
make tt ## Permet de relancer les tests automatiquement
make lint ## Permet de vérifier que le code ne contienne pas d'erreur
```

### Rendre le code Open Source

La version actuelle du site contient beaucoup de choses en dur ce qui empêche le code d'être partagé sans risque. L'objectif de cette version est donc de créer un code qui puisse être utilisé et lancé facilement par les personnes qui souhaitent collaborer.

## Design

Pour le design j'utilise [Figma](https://www.figma.com) car c'est l'outil le plus simple à utiliser pour collaborer rapidement.

- [Maquettes Figma](https://www.figma.com/file/HnamCOnYf7eWZCtRIru5o1/Site?node-id=17%3A2)

## Tips

Lien de redirection pour l'oauth https://grafikart.fr/oauth/check/{github|google|facebook}

## Nginx config

https://www.digitalocean.com/community/tools/nginx?domains.0.server.domain=test.grafikart.fr&domains.0.server.path=%2Fhome%2Fgrafikart%2Ftest.grafikart.fr&domains.0.logging.accessLog=true&domains.0.logging.errorLog=true&global.security.limitReq=true&global.php.phpServer=%2Fvar%2Frun%2Fphp%2Fphp7.4-fpm.sock&global.logging.accessLog=%2Fvar%2Flog%2Fnginx%2Faccess.log%20warn&global.logging.errorLog=%2Fvar%2Flog%2Fnginx%2Ferror.log%20warn%20warn
            ",
            'published_at' => now(),
            'submitted_at' => now()->subHours(3),
            'approved_at' => now()->subHour(),
            'show_toc' => false,
            'canonical_url' => null,
            'user_id' => (int) array_rand($usersIds),
        ]);
        $article6->syncTags(array_rand($tagsIds, 3));
        $article6->addMediaFromUrl("https://unsplash.it/1920/1080?random={$article6->id}")
            ->toMediaCollection('media');
    }
}
