<?php

use Livewire\Component;
use App\Jobs\TodoReminderJob;
use TallStackUi\Traits\Interactions;
use Carbon\Carbon;


new class extends Component {
    use Interactions;
    public string $task = "";
    public $date = null;
    public $time = null;
    public $timezone;
    
    public function add()
    {

        $utcTime = Carbon::parse($this->date . " " . $this->time, $this->timezone)->utc();
        $todo = Auth::user()
            ->todo()->firstOrCreate(["name" => "general"])
            ->subTodo()->create([
                    "work" => $this->task,
                    "reminder" => $utcTime

                ]);
        TodoReminderJob::dispatch($todo);
        $this->toast()->success("Task added", `Task added successfully`)->flash()->send();
        $this->dispatch("added", $todo); // this is done so that we can listen 
    }
};
?>

<section class=" w-screen h-screen flex justify-center items-center rounded" {{ $attributes }}>
    <div class="md:w-[40%] lg:w-[30%] w-[70%] bg-violet-50">
        <div class="p-6 py-9">
            <button x-on:click="open=! open">X</button>
            <form wire:submit="add" id="todo form">
                <x-input type="text" label="task*" hint="task" wire:model="task" required></x-input>
                <x-date label="Reminder" hint="remind me" wire:model="date" />
                <x-time format="24" label="time" hint="time for completion" wire:model="time" />
                <x-input id="timezone" label="timeZone" wire:model="timezone" x-data
                {{-- x-init="$el.value = Intl.DateTimeFormat().resolvedOptions().timeZone; $el.dispatchEvent(new Event('input'));" --}}
                />
                <x-button submit>submit</x-button>
            </form>
        </div>
    </div>
    <script>
        this.$on('added', (data) => {
            if (data) {
                let todo = JSON.parse(localStorage.getItem("todo")) || [];
                todo.push(data[0])
                localStorage.setItem("todo", JSON.stringify(todo));

                // call to update list
                updateTodoComponent()
            }
        });
        $wire.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone



    </script>
</section>