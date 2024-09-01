<section class="w-4/5 mx-auto my-8 p-6 bg-gray-100 rounded-lg shadow-lg">
    <h3 class="font-bold text-2xl mb-4">{{ $title }}</h3>
    <p class="text-gray-700">{{ $description }}</p>
    <div {{ $attributes->merge(['class' => '']) }}>
        {{ $content }}
    </div>
</section>