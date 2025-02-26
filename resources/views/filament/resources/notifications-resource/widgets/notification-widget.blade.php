<div>
    <h2 class="text-lg font-bold">Notifications</h2>
    @forelse ($this->getNotifications() as $notification)
        <div class="p-4 border rounded-lg mb-2 bg-white shadow">
            <p class="mb-2">{{ $notification->message }}</p>
            @if($notification->task)
                <p class="text-sm text-gray-600">Tâche: {{ $notification->task->title }}</p>
            @endif
            @if($notification->employee)
                <p class="text-sm text-gray-600">Employé: {{ $notification->employee->name }}</p>
            @endif
            <small class="text-gray-500">
                Ajoutée le {{ $notification->created_at->format('d/m/Y à H:i') }}
            </small>
        </div>
    @empty
        <p>Aucune notification pour le moment.</p>
    @endforelse
</div>