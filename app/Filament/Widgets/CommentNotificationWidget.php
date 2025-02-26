<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentNotificationWidget extends Widget
{
    protected static ?int $sort = 3;
    protected static string $view = 'filament.widgets.comment-notification-widget';
    protected int|string|array $columnSpan = '1/2';
    
    public function getViewData(): array
    {
        $now = Carbon::now();
        
        // Récupérer uniquement les commentaires récents avec les détails
        $recentComments = DB::table('user_tasks')
            ->select('user_tasks.commentaire', 'user_tasks.name_employee', 'user_tasks.updated_at')
            ->whereDate('user_tasks.updated_at', '>=', $now->subDays(3))
            ->whereNotNull('user_tasks.commentaire')
            ->orderBy('user_tasks.updated_at', 'desc')
            ->limit(5)
            ->get();
        
        return [
            'recentComments' => $recentComments
        ];
    }
}