<div class="p-4 bg-amber-100 rounded-lg shadow-lg border-l-4 border-amber-800 transition-all duration-300 hover:shadow-xl">
    <!-- La couleur principale de fond est bg-amber-100 (fond ambre très clair/beige) -->
    <div class="flex justify-between items-center mb-3">
        <h3 class="text-lg font-bold text-amber-900 flex items-center">
            <span class="mr-2 animate-bounce">🔔</span> Notifications des tâches
        </h3>
        <div class="flex space-x-2">
            <button id="sound-toggle" class="text-amber-700 hover:text-amber-900 p-1 rounded hover:bg-amber-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6a9 9 0 010 12M8.464 8.464a5 5 0 010 7.072" />
                </svg>
            </button>
            <button id="clear-all" class="text-amber-700 hover:text-amber-900 p-1 rounded hover:bg-amber-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span class="ml-1 text-sm">Tout effacer</span>
            </button>
        </div>
    </div>
    
    <ul id="tasks-list" class="mt-2 space-y-3">
        @forelse ($this->getData()['tasks'] as $task)
            @php
                $deadline = \Carbon\Carbon::parse($task->deadline);
                $now = \Carbon\Carbon::now();
                $hoursRemaining = $now->diffInHours($deadline, false);
                
                // Définir les classes en fonction de l'urgence
                if ($hoursRemaining < 0) {
                    // En retard
                    $bgColor = "bg-red-300";
                    $borderColor = "border-red-700";
                    $textColor = "text-red-900";
                    $animation = "shake 1.5s infinite";
                    $icon = "🚨";
                } elseif ($hoursRemaining <= 24) {
                    // Très urgent (moins de 24h)
                    $bgColor = "bg-orange-300";
                    $borderColor = "border-orange-700";
                    $textColor = "text-orange-900";
                    $animation = "shake 3s infinite";
                    $icon = "⏰";
                } elseif ($hoursRemaining <= 72) {
                    // Urgent (moins de 3 jours)
                    $bgColor = "bg-amber-300";
                    $borderColor = "border-amber-700";
                    $textColor = "text-amber-900";
                    $animation = "pulse 3s infinite";
                    $icon = "⏳";
                } else {
                    // Normal
                    $bgColor = "bg-yellow-200";
                    $borderColor = "border-yellow-600";
                    $textColor = "text-yellow-800";
                    $animation = "";
                    $icon = "📅";
                }
            @endphp
            <li class="p-4 rounded-md shadow {{ $bgColor }} border-l-4 {{ $borderColor }} transform transition-all duration-300 hover:scale-105 hover:shadow-md relative task-item" style="animation: {{ $animation }}">
                <div class="flex items-start">
                    <div class="mr-3 mt-1">
                        <span class="text-xl animate-pulse">{{ $icon }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <strong class="{{ $textColor }} text-lg">{{ $task->checklist->description }}</strong>
                            <button onclick="removeTask({{ $task->id }})" class="text-gray-600 hover:text-red-600 p-1 rounded-full hover:bg-red-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div class="flex items-center text-sm {{ $textColor }}">
                                <span class="mr-2">📆</span> Échéance : 
                                <span class="font-semibold ml-1">{{ $deadline->format('d/m/Y à H:i') }}</span>
                            </div>
                            <div class="flex items-center text-sm {{ $textColor }}">
                                <span class="mr-2">⏱️</span> Temps restant :
                                @if ($hoursRemaining < 0)
                                    <span class="font-bold ml-1 text-red-700">En retard de {{ abs($hoursRemaining) }}h</span>
                                @elseif ($hoursRemaining < 24)
                                    <span class="font-bold ml-1 text-orange-700">{{ $hoursRemaining }}h restantes</span>
                                @elseif ($hoursRemaining < 48)
                                    <span class="font-semibold ml-1">{{ floor($hoursRemaining / 24) }}j {{ $hoursRemaining % 24 }}h</span>
                                @else
                                    <span class="font-semibold ml-1">{{ floor($hoursRemaining / 24) }} jours</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="text-amber-800 p-3 bg-amber-50 rounded-md border-l-4 border-amber-300 flex items-center">
                <span class="text-xl mr-2 animate-pulse">✅</span> Aucune tâche urgente pour le moment.
            </li>
        @endforelse
    </ul>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
        20%, 40%, 60%, 80% { transform: translateX(2px); }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    .animate-pulse {
        animation: pulse 1.5s infinite;
    }
    
    .animate-bounce {
        animation: bounce 1s infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
</style>

<script>
    function removeTask(taskId) {
        // Animation de disparition
        const taskElement = event.target.closest('.task-item');
        taskElement.classList.add('opacity-0', 'scale-95');
        
        // Attendre la fin de l'animation puis supprimer
        setTimeout(() => {
            // Ici vous appelleriez votre méthode Livewire pour supprimer la tâche
            // Exemple: Livewire.emit('removeTask', taskId);
            
            taskElement.remove();
            
            // Vérifier s'il reste des tâches
            const tasksList = document.getElementById('tasks-list');
            if (tasksList.children.length === 0) {
                tasksList.innerHTML = `
                    <li class="text-amber-800 p-3 bg-amber-50 rounded-md border-l-4 border-amber-300 flex items-center">
                        <span class="text-xl mr-2 animate-pulse">✅</span> Aucune tâche urgente pour le moment.
                    </li>
                `;
            }
        }, 300);
    }
    
    // Pour le bouton "Tout effacer"
    document.getElementById('clear-all').addEventListener('click', function() {
        const tasks = document.querySelectorAll('.task-item');
        
        tasks.forEach((task, index) => {
            setTimeout(() => {
                task.classList.add('opacity-0', 'scale-95');
                
                setTimeout(() => {
                    task.remove();
                    
                    // Vérifier si c'était le dernier élément
                    if (index === tasks.length - 1) {
                        const tasksList = document.getElementById('tasks-list');
                        tasksList.innerHTML = `
                            <li class="text-amber-800 p-3 bg-amber-50 rounded-md border-l-4 border-amber-300 flex items-center">
                                <span class="text-xl mr-2 animate-pulse">✅</span> Aucune tâche urgente pour le moment.
                            </li>
                        `;
                    }
                }, 300);
            }, index * 100); // Effet en cascade
        });
        
        // Livewire.emit('clearAllTasks');
    });
</script>