<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checklist Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('report.index') }}"
                        class="mb-6 flex flex-wrap gap-4 items-center">
                        <x-text-input type="date" name="start_date" value="{{ request('start_date') }}" />
                        <x-text-input type="date" name="end_date" value="{{ request('end_date') }}" />
                        <x-primary-button>{{ __('Filter') }}</x-primary-button>
                    </form>

                    <!-- Data Table (Styled Like Your Custom Component) -->
                    <x-report-table :data="$checklists" :headers="$headers" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
