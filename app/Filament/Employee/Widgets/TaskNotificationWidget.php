<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Task;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class TaskNotificationWidget extends Widget
{
    protected static string $view = 'filament.employee.widgets.task-notification-widget';

    protected int | string | array $columnSpan = 'full';

    public function getData(): array
    {
        $today = Carbon::today();
        $upcomingTasks = Task::whereDate('deadline', '>=', $today)
            ->orderBy('deadline', 'asc')
            ->get();

        return [
            'tasks' => $upcomingTasks,
        ];
    }
}
