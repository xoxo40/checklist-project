<x-filament-widgets::widget>
    <x-filament::section>
    <div class="relative">
    <button>
        <x-heroicon-o-bell class="w-6 h-6 text-gray-500" />
        @if($notifications->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                {{ $notifications->count() }}
            </span>
        @endif
    </button>

    <div class="mt-2 bg-white border rounded shadow-lg">
        @foreach ($notifications as $notification)
            <div class="p-2 border-b">
                <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong>
                <p>{{ $notification->data['message'] ?? 'Nouvelle notification' }}</p>
            </div>
        @endforeach
    </div>
</div>

    </x-filament::section>
</x-filament-widgets::widget>
