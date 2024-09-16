@props(['size' => '4'])

<div>
    <button id="darkModeToggle" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" id="darkModeIcon" class="w-{{ $size }} h-{{ $size }}">
            <path id="lightModePath" stroke-linecap="round" stroke-linejoin="round"
                  d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            <path id="darkModePath" stroke-linecap="round" stroke-linejoin="round"
                  d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" style="display: none;" />
        </svg>
        <span class="sr-only">Toggle Dark Mode</span>
    </button>
</div>

<script nonce="{{ csp_nonce() }}" defer>
    if (localStorage.getItem('dark') === 'true') {
        document.documentElement.classList.add('dark');
        document.getElementById('lightModePath').style.display = 'none';
        document.getElementById('darkModePath').style.display = 'block';
    } else {
        document.documentElement.classList.remove('dark');
        document.getElementById('darkModePath').style.display = 'none';
        document.getElementById('lightModePath').style.display = 'block';
    }

    document.getElementById('darkModeToggle').addEventListener('click', function () {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('dark', isDark);

        if (isDark) {
            document.getElementById('lightModePath').style.display = 'none';
            document.getElementById('darkModePath').style.display = 'block';
        } else {
            document.getElementById('darkModePath').style.display = 'none';
            document.getElementById('lightModePath').style.display = 'block';
        }
    });
</script>
