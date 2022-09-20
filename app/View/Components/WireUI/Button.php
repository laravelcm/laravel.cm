<?php

namespace App\View\Components\WireUI;

use WireUi\View\Components;

class Button extends Components\Button
{
    public function defaultColors(): array
    {
        return [
            self::DEFAULT => <<<'EOT'
                border text-skin-base bg-skin-button hover:bg-skin-button-hover border-skin-input
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500
            EOT,

            'primary' => <<<'EOT'
                ring-primary-500 text-white bg-primary-500 hover:bg-primary-600 hover:ring-primary-600
                dark:ring-offset-slate-800 dark:bg-primary-700 dark:ring-primary-700
                dark:hover:bg-primary-600 dark:hover:ring-primary-600
            EOT,

            'secondary' => <<<'EOT'
                ring-secondary-500 text-white bg-secondary-500 hover:bg-secondary-600 hover:ring-secondary-600
                dark:ring-offset-slate-800 dark:bg-secondary-700 dark:ring-secondary-700
                dark:hover:bg-secondary-600 dark:hover:ring-secondary-600
            EOT,

            'positive' => <<<'EOT'
                ring-positive-500 text-white bg-positive-500 hover:bg-positive-600 hover:ring-positive-600
                dark:ring-offset-slate-800 dark:bg-positive-700 dark:ring-positive-700
                dark:hover:bg-positive-600 dark:hover:ring-positive-600
            EOT,

            'negative' => <<<'EOT'
                ring-negative-500 text-white bg-negative-500 hover:bg-negative-600 hover:ring-negative-600
                dark:ring-offset-slate-800 dark:bg-negative-700 dark:ring-negative-700
                dark:hover:bg-negative-600 dark:hover:ring-negative-600
            EOT,

            'warning' => <<<'EOT'
                ring-warning-500 text-white bg-warning-500 hover:bg-warning-600 hover:ring-warning-600
                dark:ring-offset-slate-800 dark:bg-warning-700 dark:ring-warning-700
                dark:hover:bg-warning-600 dark:hover:ring-warning-600
            EOT,

            'info' => <<<'EOT'
                ring-info-500 text-white bg-info-500 hover:bg-info-600 hover:ring-info-600
                dark:ring-offset-slate-800 dark:bg-info-700 dark:ring-info-700
                dark:hover:bg-info-600 dark:hover:ring-info-600
            EOT,

            'dark' => <<<'EOT'
                ring-gray-700 text-white bg-gray-700 hover:bg-gray-900 hover:ring-gray-900
                dark:ring-offset-gray-800 dark:bg-gray-700 dark:ring-gray-700
                dark:hover:bg-gray-600 dark:hover:ring-gray-600
            EOT,

            'white' => <<<'EOT'
                bg-white border text-slate-500 hover:bg-slate-50 ring-slate-200
                dark:text-slate-200 dark:ring-slate-700 dark:border-slate-700
                dark:bg-slate-700 dark:hover:bg-slate-600 dark:hover:ring-slate-600
                dark:ring-offset-slate-800
            EOT,

            'black' => <<<'EOT'
                bg-black text-slate-100 hover:bg-slate-900 ring-black
                dark:ring-slate-700 dark:border-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600
                dark:ring-offset-slate-800 dark:hover:ring-slate-600
            EOT,

            'slate' => <<<'EOT'
                ring-slate-500 text-white bg-slate-500 hover:bg-slate-600 hover:ring-slate-600
                dark:ring-offset-slate-800 dark:bg-slate-700 dark:ring-slate-700
                dark:hover:bg-slate-600 dark:hover:ring-slate-600
            EOT,

            'gray' => <<<'EOT'
                ring-gray-500 text-white bg-gray-500 hover:bg-gray-600 hover:ring-gray-600
                dark:ring-offset-slate-800 dark:bg-gray-700 dark:ring-gray-700
                dark:hover:bg-gray-600 dark:hover:ring-gray-600
            EOT,

            'zinc' => <<<'EOT'
                ring-zinc-500 text-white bg-zinc-500 hover:bg-zinc-600 hover:ring-zinc-600
                dark:ring-offset-slate-800 dark:bg-zinc-700 dark:ring-zinc-700
                dark:hover:bg-zinc-600 dark:hover:ring-zinc-600
            EOT,

            'neutral' => <<<'EOT'
                ring-neutral-500 text-white bg-neutral-500 hover:bg-neutral-600 hover:ring-neutral-600
                dark:ring-offset-slate-800 dark:bg-neutral-700 dark:ring-neutral-700
                dark:hover:bg-neutral-600 dark:hover:ring-neutral-600
            EOT,

            'stone' => <<<'EOT'
                ring-stone-500 text-white bg-stone-500 hover:bg-stone-600 hover:ring-stone-600
                dark:ring-offset-slate-800 dark:bg-stone-700 dark:ring-stone-700
                dark:hover:bg-stone-600 dark:hover:ring-stone-600
            EOT,

            'red' => <<<'EOT'
                ring-red-500 text-white bg-red-500 hover:bg-red-600 hover:ring-red-600
                dark:ring-offset-slate-800 dark:bg-red-700 dark:ring-red-700
                dark:hover:bg-red-600 dark:hover:ring-red-600
            EOT,

            'orange' => <<<'EOT'
                ring-orange-500 text-white bg-orange-500 hover:bg-orange-600 hover:ring-orange-600
                dark:ring-offset-slate-800 dark:bg-orange-700 dark:ring-orange-700
                dark:hover:bg-orange-600 dark:hover:ring-orange-600
            EOT,

            'amber' => <<<'EOT'
                ring-amber-500 text-white bg-amber-500 hover:bg-amber-600 hover:ring-amber-600
                dark:ring-offset-slate-800 dark:bg-amber-700 dark:ring-amber-700
                dark:hover:bg-amber-600 dark:hover:ring-amber-600
            EOT,

            'lime' => <<<'EOT'
                ring-lime-500 text-white bg-lime-500 hover:bg-lime-600 hover:ring-lime-600
                dark:ring-offset-slate-800 dark:bg-lime-700 dark:ring-lime-700
                dark:hover:bg-lime-600 dark:hover:ring-lime-600
            EOT,

            'green' => <<<'EOT'
                ring-green-500 text-white bg-green-500 hover:bg-green-600 hover:ring-green-600
                dark:ring-offset-slate-800 dark:bg-green-700 dark:ring-green-700
                dark:hover:bg-green-600 dark:hover:ring-green-600
            EOT,

            'emerald' => <<<'EOT'
                ring-emerald-500 text-white bg-emerald-500 hover:bg-emerald-600 hover:ring-emerald-600
                dark:ring-offset-slate-800 dark:bg-emerald-700 dark:ring-emerald-700
                dark:hover:bg-emerald-600 dark:hover:ring-emerald-600
            EOT,

            'teal' => <<<'EOT'
                ring-teal-500 text-white bg-teal-500 hover:bg-teal-600 hover:ring-teal-600
                dark:ring-offset-slate-800 dark:bg-teal-700 dark:ring-teal-700
                dark:hover:bg-teal-600 dark:hover:ring-teal-600
            EOT,

            'cyan' => <<<'EOT'
                ring-cyan-500 text-white bg-cyan-500 hover:bg-cyan-600 hover:ring-cyan-600
                dark:ring-offset-slate-800 dark:bg-cyan-700 dark:ring-cyan-700
                dark:hover:bg-cyan-600 dark:hover:ring-cyan-600
            EOT,

            'sky' => <<<'EOT'
                ring-sky-500 text-white bg-sky-500 hover:bg-sky-600 hover:ring-sky-600
                dark:ring-offset-slate-800 dark:bg-sky-700 dark:ring-sky-700
                dark:hover:bg-sky-600 dark:hover:ring-sky-600
            EOT,

            'blue' => <<<'EOT'
                ring-blue-500 text-white bg-blue-500 hover:bg-blue-600 hover:ring-blue-600
                dark:ring-offset-slate-800 dark:bg-blue-700 dark:ring-blue-700
                dark:hover:bg-blue-600 dark:hover:ring-blue-600
            EOT,

            'indigo' => <<<'EOT'
                ring-indigo-500 text-white bg-indigo-500 hover:bg-indigo-600 hover:ring-indigo-600
                dark:ring-offset-slate-800 dark:bg-indigo-700 dark:ring-indigo-700
                dark:hover:bg-indigo-600 dark:hover:ring-indigo-600
            EOT,

            'violet' => <<<'EOT'
                ring-violet-500 text-white bg-violet-500 hover:bg-violet-600 hover:ring-violet-600
                dark:ring-offset-slate-800 dark:bg-violet-700 dark:ring-violet-700
                dark:hover:bg-violet-600 dark:hover:ring-violet-600
            EOT,

            'purple' => <<<'EOT'
                ring-purple-500 text-white bg-purple-500 hover:bg-purple-600 hover:ring-purple-600
                dark:ring-offset-slate-800 dark:bg-purple-700 dark:ring-purple-700
                dark:hover:bg-purple-600 dark:hover:ring-purple-600
            EOT,

            'fuchsia' => <<<'EOT'
                ring-fuchsia-500 text-white bg-fuchsia-500 hover:bg-fuchsia-600 hover:ring-fuchsia-600
                dark:ring-offset-slate-800 dark:bg-fuchsia-700 dark:ring-fuchsia-700
                dark:hover:bg-fuchsia-600 dark:hover:ring-fuchsia-600
            EOT,

            'pink' => <<<'EOT'
                ring-pink-500 text-white bg-pink-500 hover:bg-pink-600 hover:ring-pink-600
                dark:ring-offset-slate-800 dark:bg-pink-700 dark:ring-pink-700
                dark:hover:bg-pink-600 dark:hover:ring-pink-600
            EOT,

            'rose' => <<<'EOT'
                ring-rose-500 text-white bg-rose-500 hover:bg-rose-600 hover:ring-rose-600
                dark:ring-offset-slate-800 dark:bg-rose-700 dark:ring-rose-700
                dark:hover:bg-rose-600 dark:hover:ring-rose-600
            EOT,
        ];
    }
}
