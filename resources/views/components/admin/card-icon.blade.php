<div {{ $attributes->merge(['class' => 'max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700']) }}>
    {{ $icon }}
    <div>
        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
    </div>
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ $description }}</p>
    <div class="inline-flex font-medium items-center text-blue-600 w-full">
        {{ $slot }}
    </div>
</div>
