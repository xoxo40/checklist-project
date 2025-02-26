<x-filament::widget>
    <x-filament::card>
        <div id="commentaires-widget">
            <h2 class="text-lg font-bold flex items-center filament-text-indigo-700">
                <span class="mr-2">💬</span> Commentaires Récents
            </h2>
            
            @php
                $data = $this->getViewData();
            @endphp
            
            <div class="mt-3">
                @if(count($data['recentComments']) > 0)
                    <ul class="space-y-3">
                        @foreach($data['recentComments'] as $comment)
                            <li class="p-3 rounded-lg border-l-4 comment-item" style="border-color: #6366f1; background-color: #eef2ff;">
                                <div class="font-medium" style="color: #4338ca;">
                                    <x-heroicon-o-user class="inline-block w-5 h-5 mr-2" style="color: #6366f1;" />
                                    <span>{{ $comment->name_employee }}</span>
                                    <span class="mx-2" style="color: #a5b4fc;">•</span>
                                    <span style="color: #6366f1; font-size: 0.875rem;">{{ \Carbon\Carbon::parse($comment->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="mt-2 pl-7" style="color: #4b5563;">{{ $comment->commentaire }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="py-6 flex flex-col items-center justify-center text-gray-500">
                        <x-heroicon-o-chat-bubble-left-right class="w-12 h-12 mb-2" style="color: #d1d5db;" />
                        <p>Aucun commentaire récent.</p>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour l'emoji
    const emojiElement = document.querySelector('#commentaires-widget h2 span');
    setInterval(function() {
        emojiElement.style.opacity = '0.5';
        setTimeout(function() {
            emojiElement.style.opacity = '1';
        }, 500);
    }, 1500);
    
    // Animation pour les éléments de commentaire
    const commentItems = document.querySelectorAll('.comment-item');
    commentItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease-out';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 150);
        
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>