<div  {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-9']) }}>
    <table class="w-full col-span-6 sm:col-md-6 divide-y divide-cool-gray-200">
        <thead  class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>
                {{ $theaders }}
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-cool-gray-200">
            {{ $tbody }}
        </tbody>
    </table>
</div>