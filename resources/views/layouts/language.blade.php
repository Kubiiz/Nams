<x-nav-lang :href="route('language', 'lv')" :active="app()->isLocale('lv')">{{ 'lv' }}</x-nav-lang>
<x-nav-lang :href="route('language', 'en')" :active="app()->isLocale('en')">{{ 'en' }}</x-nav-lang>
