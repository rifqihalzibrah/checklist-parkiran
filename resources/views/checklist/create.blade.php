<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checklist Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('checklist.store') }}">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            {{-- <x-input-label for="time" :value="__('Time')" />
                            <x-text-input id="time" name="time" type="datetime-local" class="block mt-1 w-full"
                                required autofocus /> --}}

                            <x-input-label for="brand" :value="__('Brand')" />
                            <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand"
                                required />

                            <x-input-label for="plate" :value="__('Plate')" />
                            <x-text-input id="plate" class="block mt-1 w-full" type="text" name="plate"
                                required />

                            <x-input-label for="mirror" :value="__('Mirror')" />
                            <x-text-input id="mirror" class="block mt-1 w-full" type="text" name="mirror"
                                required />

                            <x-input-label for="disc" :value="__('Disc')" />
                            <x-text-input id="disc" class="block mt-1 w-full" type="text" name="disc"
                                required />

                            <x-input-label for="jacket" :value="__('Jacket')" />
                            <x-text-input id="jacket" class="block mt-1 w-full" type="text" name="jacket"
                                required />

                            <x-input-label for="tire" :value="__('Tire')" />
                            <x-text-input id="tire" class="block mt-1 w-full" type="text" name="tire"
                                required />

                            <x-input-label for="helmet" :value="__('Helmet')" />
                            <x-text-input id="helmet" class="block mt-1 w-full" type="text" name="helmet"
                                required />

                            <x-input-label for="vehicle_condition" :value="__('Vehicle Condition')" />
                            <x-textarea id="vehicle_condition" class="block mt-1 w-full" name="vehicle_condition" />

                            <x-input-label for="notes" :value="__('Notes')" />
                            <x-textarea id="notes" class="block mt-1 w-full" name="notes" />

                            {{-- <x-input-label for="status" :value="__('Status')" />
                            <x-select name="status" id="status">
                                <option value="draft">Draft</option>
                            </x-select> --}}
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('checklist.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
