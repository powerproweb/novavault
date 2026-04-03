@props(['label', 'value', 'accent' => 'nv-blue'])

<div class="bg-surface border border-stroke rounded-nv p-5">
    <dt class="text-sm text-gray-400">{{ $label }}</dt>
    <dd class="mt-1 text-2xl font-bold text-{{ $accent }}">{{ $value }}</dd>
</div>
