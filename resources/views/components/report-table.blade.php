@props(['data', 'headers'])

<div x-data="{
    search: '',
    sortColumn: '',
    sortDirection: 'asc',
    sort(column) {
        this.sortColumn = column;
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
    },
    get filteredData() {
        return ({{ json_encode($data) }} || [])
            .filter(row => Object.values(row).some(val =>
                (val ?? '').toString().toLowerCase().includes(this.search.toLowerCase())
            ))
            .sort((a, b) => {
                if (!this.sortColumn) return 0;
                let valA = (a[this.sortColumn] ?? '').toString();
                let valB = (b[this.sortColumn] ?? '').toString();
                return this.sortDirection === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
            });
    }
}">
    <!-- Top Bar with Export Button -->
    <div class="mb-4 flex flex-wrap justify-between items-center gap-4">
        {{-- <x-text-input type="text" x-model="search" placeholder="Search..."
            class="px-3 py-2 text-sm text-black w-full sm:w-1/3" /> --}}

        <a href="{{ route('reports.export', request()->query()) }}"
            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Export Excel
        </a>
    </div>

    <!-- Scrollable Table -->
    <div class="w-full overflow-x-auto">
        <table class="table-auto w-full border text-left text-sm">
            <thead>
                <tr>
                    @foreach ($headers as $header)
                        <th class="px-4 py-2 cursor-pointer border-b" @click="sort('{{ $header }}')">
                            {{ ucfirst(str_replace('_', ' ', $header)) }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <template x-if="filteredData.length > 0">
                    <template x-for="row in filteredData" :key="row.id">
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            @foreach ($headers as $header)
                                <td class="border px-4 py-2">
                                    <template x-if="'{{ $header }}' === 'time'">
                                        <span x-text="new Date(row['{{ $header }}']).toLocaleString()"></span>
                                    </template>

                                    <template
                                        x-if="'{{ $header }}' === 'chief_approved' || '{{ $header }}' === 'supervisor_approved'">
                                        <span x-text="row['{{ $header }}'] ? '✅' : '❌'"></span>
                                    </template>

                                    <template
                                        x-if="!['time', 'chief_approved', 'supervisor_approved'].includes('{{ $header }}')">
                                        <span x-text="row['{{ $header }}'] ?? '-'"></span>
                                    </template>
                                </td>
                            @endforeach
                        </tr>
                    </template>
                </template>
                <template x-if="filteredData.length === 0">
                    <tr>
                        <td colspan="{{ count($headers) }}" class="text-center py-4 text-gray-500">
                            No records found.
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
