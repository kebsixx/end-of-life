<x-filament::page>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Duration
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('first_installation_date')">
                            First Install
                            @if ($sortField === 'first_installation_date')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('last_installation_date')">
                            Last Install
                            @if ($sortField === 'last_installation_date')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('release_date')">
                            Release Date
                            @if ($sortField === 'release_date')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('expiry_date')">
                            Expiry Date
                            @if ($sortField === 'expiry_date')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($data as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $category->product_name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $category->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $category->manufactur->first()?->license_duration ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $category->manufactur->first()?->first_installation_date?->translatedFormat('j F Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $category->manufactur->first()?->last_installation_date?->translatedFormat('j F Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $category->version?->release_date?->translatedFormat('j F Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $category->version?->expiry_date?->translatedFormat('j F Y') ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>
