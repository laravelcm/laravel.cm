<x-nav.item
    :href="route('forum.index')"
    :active-links="['forum', 'forum*']"
    :title="__('global.navigation.forum')"
/>
<x-nav.item
    :href="route('articles')"
    :active-links="['articles', 'articles*']"
    :title="__('global.navigation.articles')"
/>
<x-nav.item
    :href="route('discussions.index')"
    :active-links="['discussions', 'discussions*']"
    :title="__('global.navigation.discussions')"
/>
<x-nav.item
    href="#"
    :active-links="['community']"
    :title="__('global.navigation.community')"
/>
