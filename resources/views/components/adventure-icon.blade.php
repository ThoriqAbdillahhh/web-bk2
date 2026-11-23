@props(['name', 'class' => 'h-4 w-4'])

<svg {{ $attributes->class($class) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
    @switch($name)
        @case('home')
            <path fill="currentColor" d="m3.3 10.4 7.8-6.2a1.5 1.5 0 0 1 1.8 0l7.8 6.2a1.5 1.5 0 0 1-.9 2.7h-.6v5.1a1.8 1.8 0 0 1-1.8 1.8h-3.3v-5.4h-3.6V20H7.2a1.8 1.8 0 0 1-1.8-1.8v-5.1h-.6a1.5 1.5 0 0 1-1.5-2.7Z"/>
            @break
        @case('class')
            <path fill="currentColor" d="M4.2 4.5A1.5 1.5 0 0 1 5.7 3h12.6a1.5 1.5 0 0 1 1.5 1.5v13.8a1.2 1.2 0 0 1-1.8 1l-5.4-3-5.4 3a1.2 1.2 0 0 1-1.8-1V4.5Z"/>
            <path fill="white" d="M8 7h8v1.5H8zM8 10.5h8V12H8z"/>
            @break
        @case('people')
            <circle cx="9" cy="8" r="3.5" fill="currentColor"/>
            <path fill="currentColor" d="M2.5 19.2a6.5 6.5 0 0 1 13 0v.3h-13v-.3Zm12.3-7.9a3 3 0 1 0-1.1-5.8 5 5 0 0 1 0 5.8Zm1.7 1.5a5 5 0 0 1 4.8 5v1.7h-5v-.3a8 8 0 0 0-2.1-5.4 5 5 0 0 1 2.3-1Z"/>
            @break
        @case('flag')
            <path d="M6 21V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path fill="currentColor" d="M7 4h11.5l-2.2 4 2.2 4H7V4Zm-1 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
            @break
        @case('progress')
            <path fill="currentColor" d="M4 13h3.5v7H4zm6.2-5h3.6v12h-3.6zm6.3-5H20v17h-3.5z"/>
            <path d="m4.5 9 4.2-3.5 3.1 1.2 5-4 2.7 1.1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('survey')
            <path fill="currentColor" d="M7 3h10a2 2 0 0 1 2 2v15a1 1 0 0 1-1.5.9L12 18l-5.5 2.9A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2Z"/>
            <path d="m8 8 1.2 1.2L11.5 7m1.5 2h3M8 14l1.2 1.2 2.3-2.2m1.5 2h3" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('chat')
            <path fill="currentColor" d="M12 3.5c-5.2 0-9.5 3.5-9.5 7.9 0 2.2 1.2 4.2 3.1 5.6l-.8 3.3 4-1.7c1 .3 2.1.5 3.2.5 5.2 0 9.5-3.5 9.5-7.8S17.2 3.5 12 3.5Z"/>
            <circle cx="8" cy="11.5" r="1" fill="white"/>
            <circle cx="12" cy="11.5" r="1" fill="white"/>
            <circle cx="16" cy="11.5" r="1" fill="white"/>
            @break
        @case('guide')
            <path fill="currentColor" d="M12 6.2C9.4 4.3 6.1 4 3.5 5v13c2.6-1 5.9-.7 8.5 1.2V6.2Zm0 0c2.6-1.9 5.9-2.2 8.5-1.2v13c-2.6-1-5.9-.7-8.5 1.2V6.2Z"/>
            <path d="m16.5 2 .7 1.6 1.8.2-1.4 1.2.4 1.8-1.5-.9-1.5.9.4-1.8L14 3.8l1.8-.2.7-1.6Z" fill="currentColor"/>
            @break
        @case('map')
            <path fill="currentColor" d="m3 5.5 5.5-2 7 2 5.5-2v15l-5.5 2-7-2L3 20V5.5Z"/>
            <path d="M8.5 3.5v15m7-13v15" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M11 11.5c0-1.6 1.2-2.8 2.6-2.8s2.6 1.2 2.6 2.8c0 1.8-2.6 4.5-2.6 4.5S11 13.3 11 11.5Z" fill="white"/>
            <circle cx="13.6" cy="11.5" r=".8" fill="currentColor"/>
            @break
        @case('reflection')
            <path fill="currentColor" d="M4 4.5h16a1.5 1.5 0 0 1 1.5 1.5v10a1.5 1.5 0 0 1-1.5 1.5h-8l-5.5 3v-3H4A1.5 1.5 0 0 1 2.5 16V6A1.5 1.5 0 0 1 4 4.5Z"/>
            <path d="m12 7 .9 2 2.1.2-1.6 1.4.5 2.1-1.9-1.1-1.9 1.1.5-2.1L9 9.2l2.1-.2L12 7Z" fill="white"/>
            @break
        @case('observe')
            <path fill="currentColor" d="M12 4c-5.3 0-9.4 4.1-10.5 7.1a1.7 1.7 0 0 0 0 1.2C2.6 15.3 6.7 19.4 12 19.4s9.4-4.1 10.5-7.1a1.7 1.7 0 0 0 0-1.2C21.4 8.1 17.3 4 12 4Z"/>
            <circle cx="12" cy="11.7" r="4" fill="white"/>
            <circle cx="12" cy="11.7" r="2" fill="currentColor"/>
            @break
        @default
            <circle cx="12" cy="12" r="8" fill="currentColor"/>
    @endswitch
</svg>
