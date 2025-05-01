@props(['data', 'headers', 'routes'])

<div x-data="{
    search: '',
    sortColumn: '',
    sortDirection: 'asc',
    selectedRow: null,
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
    <!-- Top Bar -->
    <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
        <!-- Search Field -->
        <x-text-input type="text" x-model="search" placeholder="Search..."
            class="px-3 py-2 text-sm text-black w-full sm:w-1/2" />

        <!-- Action Buttons -->
        <div class="flex flex-wrap justify-end items-center gap-2">

            <!-- Submit (Admin Only, if row selected) -->
            @if (Auth::user()->hasAnyRole(['admin']))
                <form action="{{ route('checklist.submit.all') }}" method="POST" class="inline-block"
                    @click.prevent="if(confirm('Submit all eligible checklists?')) $event.target.closest('form').submit();">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7v10l9-5-9-5z" />
                        </svg>
                        Submit All
                    </button>
                </form>
            @endif

            <!-- Create (Admin Only) -->
            @if (Auth::user()->hasAnyRole(['admin']))
                <a :href="'{{ $routes['create'] }}'"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Checklist
                </a>
            @endif

            <!-- Edit (Admin Only, if row selected) -->
            @if (Auth::user()->hasAnyRole(['admin']))
                <template x-if="selectedRow">
                    <a :href="`{{ $routes['edit_base'] }}/${selectedRow.id}/edit`"
                        class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5h10M11 9h7M11 13h4m-6 0h-1a2 2 0 00-2 2v5h6v-5a2 2 0 00-2-2z" />
                        </svg>
                        Edit
                    </a>
                </template>
            @endif

            <!-- Delete (Admin Only, if row selected) -->
            @if (Auth::user()->hasAnyRole(['admin']))
                <template x-if="selectedRow">
                    <form :action="`{{ $routes['delete_base'] }}/${selectedRow.id}`" method="POST" class="inline-block"
                        @click.prevent="if(confirm('Are you sure?')) $event.target.closest('form').submit();">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </template>
            @endif

            <!-- Revition (Chief/Supervisor Only, if row selected) -->
            @if (Auth::user()->hasAnyRole(['chief', 'supervisor']))
                <template x-if="selectedRow">
                    <form :action="`{{ $routes['revision_base'] }}/${selectedRow.id}/revision`" method="POST"
                        class="inline-block"
                        @click.prevent="if(confirm('Are you sure?')) $event.target.closest('form').submit();">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5h10M11 9h7M11 13h4m-6 0h-1a2 2 0 00-2 2v5h6v-5a2 2 0 00-2-2z" />
                            </svg>
                            Revision
                        </button>
                    </form>
                </template>
            @endif

            <!-- Approve (Chief/Supervisor Only, if row selected) -->
            @if (Auth::user()->hasAnyRole(['chief', 'supervisor']))
                <form action="{{ route('checklist.approve.all') }}" method="POST" class="inline-block"
                    @click.prevent="if(confirm('Approve all checklists?')) $event.target.closest('form').submit();">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Approve All
                    </button>
                    </template>
            @endif
        </div>
    </div>

    <!-- Scrollable Table Container -->
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
                        <tr :class="selectedRow?.id === row.id ? 'bg-blue-100 dark:bg-blue-900' : ''"
                            @click="selectedRow = selectedRow?.id === row.id ? null : row"
                            class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            @foreach ($headers as $header)
                                <td class="border px-4 py-2">
                                    <template x-if="'{{ $header }}' === 'created_at'">
                                        <span x-text="new Date(row['{{ $header }}']).toLocaleString()"></span>
                                    </template>

                                    <template
                                        x-if="'{{ $header }}' === 'chief_approved' || '{{ $header }}' === 'supervisor_approved'">
                                        <span x-text="row['{{ $header }}'] ? '✅' : '❌'"></span>
                                    </template>

                                    <template
                                        x-if="!['created_at', 'chief_approved', 'supervisor_approved'].includes('{{ $header }}')">
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
