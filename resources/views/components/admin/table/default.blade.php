<div class="relative shadow-md sm:rounded-lg">
    <table class="relative w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            {{ $title }}
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                {{ $description }}
            </p>
        </caption>
        {{ $slot }}
    </table>
</div>
