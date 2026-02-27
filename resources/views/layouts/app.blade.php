<x-layouts::skeliton>
    <x-slot:title>{{ $title ?? config('app.name') }}</x-slot:title>
    {{ $slot }}

</x-layouts::skeliton>