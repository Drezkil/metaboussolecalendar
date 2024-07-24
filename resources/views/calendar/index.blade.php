<x-app-layout>
    <x-slot name="header">

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'fr',
                    timeZone: 'Europe/Paris',
                    initialView: 'timeGridWeek',
                    editable: true,
                    eventResizableFromStart: true,
                    selectable: true,
                    events: `/api/events/{{ \Illuminate\Support\Facades\Auth::id() }}`,
                    dateClick: function(info) {
                        handleDateClick(info);
                    },
                    eventClick: function(info) {
                        handleEventClick(info);
                    },
                    eventDrop: function(info) {
                        handleEventDrop(info);
                    },
                    eventResize: function(info) {
                        handleEventResize(info);
                    }
                });

                calendar.render();

                function handleDateClick(info) {
                    if (confirm('Do you want to create an event?')) {
                        let title = 'Availability';
                        let start = info.dateStr + ' ' + '06:00';
                        let end = info.dateStr + ' ' + '07:00';

                        if (title) {
                            fetch('/api/events', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    title: title,
                                    start: start,
                                    end: end,
                                    id_user: {{ \Illuminate\Support\Facades\Auth::id() }}
                                })
                            })
                                .then(response => response.json())
                                .then(event => {
                                    calendar.addEvent(event);
                                });
                        }
                        setTimeout(function(){
                            location.reload();
                        }, 500);
                    }
                }

                function handleEventClick(info) {
                    if (confirm('Do you want to delete this event?')) {
                        fetch(`/api/events/${info.event.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }})
                            .then(() => {
                                info.event.remove();
                            });
                    }
                }

                function handleEventDrop(info) {
                    console.log('Event dropped:', info.event.id, info.event.startStr, info.event.endStr, info.event.title);
                    fetch(`/api/events/${info.event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            title: info.event.title,
                            start: info.event.startStr,
                            end: info.event.endStr
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Event updated successfully:', data);
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                    setTimeout(function(){
                        location.reload();
                    }, 500);
                }

                function handleEventResize(info) {
                    console.log('Event resized:', info.event.id, info.event.startStr, info.event.endStr, info.event.title);
                    fetch(`/api/events/${info.event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            title: info.event.title,
                            start: info.event.startStr,
                            end: info.event.endStr
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Event updated successfully:', data);
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                    setTimeout(function(){
                        location.reload();
                    }, 500);
                }
            });
        </script>


        <h2 class="font-semibold text-xl text-black-800 dark:text-gray-200 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div id="calendar" class="text-white"></div>

</x-app-layout>

