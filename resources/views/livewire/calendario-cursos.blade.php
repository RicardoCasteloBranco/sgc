<div wire:ignore>
    <div id="calendar"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {

        const calendarEl = document.getElementById('calendar');

        if (!calendarEl) return;

        const calendar = new FullCalendar.Calendar(calendarEl, {

            plugins: [
                FullCalendar.dayGridPlugin,
                FullCalendar.interactionPlugin
            ],

            initialView: 'dayGridMonth',

            locale: 'pt-br',

            events: @json($events),

            height: 750,

            eventClick: function(info) {
                alert("Curso: " + info.event.title + "\n" +
                    "Inicio: " + info.event.start.toLocaleDateString('pt-BR') + "\n" +
                    "Fim: " + info.event.end.toLocaleDateString('pt-BR')
                );
            }
        });

        calendar.render();

        // EVENTO DO LIVEWIRE FORA DO CALENDAR
        Livewire.on('updateCalendar', (event) => {

            calendar.removeAllEvents();

            calendar.addEventSource(event[0]);
        });

    });
</script>
@endpush