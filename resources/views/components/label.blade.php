@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium items-center text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
