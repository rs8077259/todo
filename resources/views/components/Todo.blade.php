<div x-data="{ open: false }" class="min-h-screen bg-gray-100 py-10">
    {{-- TodoForm --}}
    <livewire:blade.todoForm x-show="open" />

    <section
        class="max-w-5xl mx-auto flex flex-col gap-6 bg-white shadow-lg rounded-xl p-6 border border-gray-100"
        x-show="! open"
    >
        <header class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Your Tasks</h1>
                <p class="text-sm text-gray-500">Manage your tasks, track progress, and keep everything in sync.</p>
            </div>
            <div class="flex items-center gap-3">
                <x-button class="m-0" x-on:click="open = !open" x-show="! open">Add +</x-button>
                <x-button id="syncButton" class="m-0">Sync</x-button>
            </div>
        </header>

        {{-- Todo component --}}
        <script>
            document.addEventListener("alpine:init", () => {

                Alpine.data('TodoComponent',
                    () => ({
                        todo: [],
                        init() {
                            this.todo = JSON.parse(localStorage.getItem("todo")) || [];

                        },
                        update() {
                            this.todo = JSON.parse(localStorage.getItem('todo'));
                        }
                    })
                )
            })

        </script>
        <div>
            <x-tab selected="Tasks">
                <x-tab.items tab="Tasks">
                    <div x-data="TodoComponent" id="todoComponent" class="mt-4">
                        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                            <table class="min-w-full text-sm text-left text-gray-700">
                                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="px-4 py-3 border-r border-gray-200 text-center">Complete</th>
                                        <th class="px-4 py-3">Work</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="obj in todo" :key="obj.id">
                                        <template x-if="!obj['completed']">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 border-r border-gray-100 text-center">
                                                    <input
                                                        type="checkbox"
                                                        :id="obj.id"
                                                        @click="() => { Completed(obj.id) }"
                                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                    >
                                                </td>
                                                <td class="px-4 py-2 font-medium text-gray-800" x-text="obj.work"></td>
                                                <td class="px-4 py-2 text-gray-600" x-text="obj['discription'] || 'No description provided'"></td>
                                                <td class="px-4 py-2 text-gray-500" x-text="new Date(obj['reminder']).toLocaleString()"></td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </x-tab.items>

                <x-tab.items tab="completed Tasks">
                    {{-- completed task go haere --}}
                    <div x-data="TodoComponent" id="todoComponent" class="mt-4">
                        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                            <table class="min-w-full text-sm text-left text-gray-700">
                                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="px-4 py-3 border-r border-gray-200 text-center">Complete</th>
                                        <th class="px-4 py-3">Work</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="obj in todo" :key="obj.id">
                                        <template x-if="obj['completed']">
                                            <tr class="bg-green-50 hover:bg-green-100">
                                                <td class="px-4 py-2 border-r border-gray-100 text-center">
                                                    <input
                                                        type="checkbox"
                                                        :id="obj.id"
                                                        checked
                                                        disabled
                                                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                                    >
                                                </td>
                                                <td class="px-4 py-2 font-medium text-gray-800" x-text="obj.work"></td>
                                                <td class="px-4 py-2 text-gray-600" x-text="obj['discription'] || 'No description provided'"></td>
                                                <td class="px-4 py-2 text-gray-500" x-text="new Date(obj['reminder']).toLocaleString()"></td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </x-tab.items>
            </x-tab>

        </div>
    </section>

    <script>
        document.getElementById('syncButton').addEventListener('click', event => {
            sync()
        })
    </script>
</div>
