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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            First Install
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Last Install
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Release Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Expiry Date
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
