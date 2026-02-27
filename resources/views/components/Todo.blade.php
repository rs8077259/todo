<div x-data="{open:false}">


    {{-- TodoForm --}}

    {{-- livewire todoForm component here --}}
    <livewire:blade.todoForm x-show="open" />

    <section class="flex flex-col items-center justify-center h-screen" x-show="! open">
        <div>
        <x-button class="m-2" x-on:click="open=! open" x-show="! open" >Add +</x-button>
        <x-button id="syncButton">Sync</x-button>
        </div>
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
        <div class="">
            <x-tab selected="Tasks">
                <x-tab.items tab="Tasks">
                    <div x-data="TodoComponent" id="todoComponent">
                        <table class="p-2 rounded-md h-10 overflow-scroll">
                            <tr class=" p-0.5 border text-center">
                                <th class="p-2 border-r">Complete</th>
                                <th class="p-2">work</th>
                                <th class="p-2">discription</th>
                                <th class="p-2">time</th>
                            </tr>
                            <template x-for="obj in todo">
                                <template x-if="!obj['completed']">
                                    <tr class=" p-0.5 border text-center">
                                        <td class="p-2 border-r"><input type="checkbox" name="" :id="obj.id"
                                                :key="obj.id" @click="()=>{Completed(obj.id)}"></td>
                                        <td class="p-2 " x-text="obj.work"></td>
                                        <td class="p-2 " x-text="obj['discription']||'no discription provided'"></td>
                                        <td class="p-2" x-text="new Date(obj['reminder']).toLocaleString()"></td>
                                    </tr>
                                </template>
                            </template>
                        </table>
                    </div>


                </x-tab.items>

                <x-tab.items tab="completed Tasks">
                    {{-- completed task go haere --}}
                    <div x-data="TodoComponent" id="todoComponent">
                        <table class="p-2 rounded-md">
                            <tr class=" p-0.5 border text-center">
                                <th class="p-2 border-r">Complete</th>
                                <th class="p-2">work</th>
                                <th class="p-2">discription</th>
                                <th class="p-2">time</th>
                            </tr>
                            <template x-for="obj in todo">
                                <template x-if="obj['completed']">
                                    <tr class=" p-0.5 border text-center">
                                        <td class="p-2 border-r"><input type="checkbox" name="" :id="obj.id" checked
                                                disabled></td>
                                        <td class="p-2 " x-text="obj.work"></td>
                                        <td class="p-2 " x-text="obj['discription']||'no discription provided'"></td>
                                        <td class="p-2" x-text="new Date(obj['reminder']).toLocaleString()"></td>
                                    </tr>
                                </template>
                            </template>
                        </table>
                    </div>
                </x-tab.items>
            </x-tab>

        </div>
    </section>
    <script>
        document.getElementById("syncButton").addEventListener('click',event=>{
            sync()
        })
    </script>
</div>