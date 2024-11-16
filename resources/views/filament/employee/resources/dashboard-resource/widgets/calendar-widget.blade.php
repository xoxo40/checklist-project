{{-- resources/views/filament/widgets/calendar-widget.blade.php --}}
<x-filament::widget>
    <x-filament::section>
        <h2 class="text-lg font-semibold mb-4">Calendrier</h2>

        <div id="calendar" class="p-4 bg-white rounded-lg shadow"></div>

        {{-- Intégration des styles et scripts pour FullCalendar --}}
        @once
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
        @endonce

        @once
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth' // Vue par défaut sans événements
                    });
                    calendar.render();
                });
            </script>
        @endonce
    </x-filament::section>
</x-filament::widget>
