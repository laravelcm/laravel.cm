<div class="relative flex items-center h-full px-4 font-medium text-skin-base space-x-4">
    <button x-data title="Codepen" type="button" class="text-skin-base hover:text-skin-inverted-muted cursor-pointer focus:outline-none" @click="$dispatch('editor-control-clicked', 'codepen')">
        <svg class="text-skin-menu fill-current w-5 h-5" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <circle fill="#374151" cx="100" cy="100" r="100"/>
                <path d="M42.275 122.561l54.845 36.57c1.87 1.15 3.87 1.165 5.76 0l54.845-36.57c1.405-.935 2.275-2.61 2.275-4.285v-36.56c0-1.675-.87-3.35-2.275-4.285L102.88 40.866c-1.87-1.15-3.87-1.16-5.76 0L42.275 77.431C40.87 78.366 40 80.041 40 81.716v36.56c0 1.675.87 3.35 2.275 4.285zm52.57 22.64l-40.38-26.92 18.015-12.055 22.365 14.935v24.04zm10.31 0v-24.04l22.365-14.935 18.015 12.055-40.38 26.92zm44.535-36.57l-12.925-8.635 12.925-8.64v17.275zm-44.535-53.835l40.38 26.92-18.015 12.055-22.365-14.935v-24.04zM100 87.806l18.215 12.19L100 112.186l-18.215-12.19L100 87.806zm-5.155-33.01v24.04L72.48 93.771 54.465 81.716l40.38-26.92zm-44.53 36.57v-.005l12.925 8.64-12.925 8.64V91.366z" fill="#FFF" fill-rule="nonzero"/>
            </g>
        </svg>
    </button>
    <button x-data title="Code sample" type="button" class="text-skin-base hover:text-skin-inverted-muted cursor-pointer focus:outline-none" @click="$dispatch('editor-control-clicked', 'code')">
        <x-heroicon-o-code class="w-5 h-5" />
    </button>
    <button x-data title="Link" type="button" class="text-skin-base hover:text-skin-inverted-muted cursor-pointer focus:outline-none" @click="$dispatch('editor-control-clicked', 'link')">
        <x-heroicon-o-link class="w-5 h-5" />
    </button>
    <button x-data title="Image" type="button" class="text-skin-base hover:text-skin-inverted-muted cursor-pointer focus:outline-none" @click="$dispatch('editor-control-clicked', 'image')">
        <x-heroicon-o-photograph class="w-5 h-5" />
    </button>
</div>
