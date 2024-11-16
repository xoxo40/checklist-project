<div>
    <h2>Mes Tâches</h2>
    <ul>
        @foreach($userTasks as $task)
            <li class="task-item">
                <label>
                    <input type="checkbox" wire:click="toggleTaskCompletion({{ $task->id }})" 
                           {{ $task->is_completed ? 'checked' : '' }}>
                    {{ $task->task_details }}
                </label>
                <span>{{ $task->date }}</span>
                @if($task->commentaire)
                    <p><strong>Commentaire :</strong> {{ $task->commentaire }}</p>
                @endif
            </li>
        @endforeach
    </ul>
</div>
