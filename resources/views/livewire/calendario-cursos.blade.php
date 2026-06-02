<div wire:ignore>
    <div id="calendar"></div>
</div>

@script
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

                alert(info.event.title);

                // Exemplo:
                // window.location.href = '/projetos/' + info.event.id;
            }
        });

        calendar.render();
    });
</script>
@endscript