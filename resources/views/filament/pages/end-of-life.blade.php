<x-filament::page>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b">
            <h1 class="text-2xl font-semibold text-gray-900">End of Life Data</h1>
            <a href="{{ route('export.excel') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-2 px-4 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] bg-primary-600 text-white border-transparent hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                Export to Excel
            </a>
        </div>
        
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
                    @foreach($this->getData() as $category)
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
