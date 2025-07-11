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
                    const crtModal = document.getElementById('crtModal')
                    crtModal.showModal();

                    document.getElementById('clsEvent').addEventListener("click", function () {
                        crtModal.close();
                    })

                    document.getElementById('crtEvent').addEventListener("click", function () {

                        const repModal = document.getElementById('repModal')
                        repModal.showModal();

                        const  select = document.getElementById('repeat')

                        var valeur;
                        select.addEventListener("change", function (){
                            valeur = this.value;
                            console.log(valeur)
                        })


                        var Start = document.getElementById('start').value
                        var End = document.getElementById('end').value

                        document.getElementById('repConfirm').addEventListener("click", function (){

                                let title = 'Availability';
                                let start = info.dateStr + ' ' + Start ;
                                let end = info.dateStr + ' ' + End ;


                                if (title) {
                                    fetch(`/api/events/${valeur}`, {
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


                            setTimeout(function () {
                                location.reload();
                            }, 500);

                        })


                    })







                }

                function handleEventClick(info) {
                    const delModal = document.getElementById('delModal')
                    delModal.showModal();

                    document.getElementById('delClose').addEventListener("click", function (){
                        delModal.close();
                    })

                    document.getElementById('delConfirm').addEventListener("click", function (){
                        fetch(`/api/events/${info.event.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }})
                            .then(() => {
                                info.event.remove();
                            });
                        delModal.close();
                    })

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

    <dialog id="crtModal" style="border-radius: 10px; padding: 20px">
        <div style="align-content: center; text-align: center">
            <p style="margin-bottom: 10px">Do you want to create an event ?</p>

            <label for="start">Start</label>
            <p></p>
            <input id="start" type="time">
            <p></p>
            <label for="end" style="margin-top: 20px">End</label>
            <p></p>
            <input id="end" type="time">

            <div style="margin-top: 20px">
                <button id="clsEvent" class="btn btn-danger" style="margin-right: 50px">No</button>
                <button id="crtEvent" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </dialog>

    <dialog id="repModal" style="border-radius: 10px; padding: 20px">
        <div style="align-content: center; text-align: center">
            <p style="margin-bottom: 20px">How many times do you want to repeat this event ?</p>
            <select id="repeat">
                <option value="">Do not repeat</option>
                <option value="Weekly">Weekly</option>
                <option value="Monthly">Monthly</option>
                <option value="Everyday">Everyday</option>
            </select>
            <button id="repConfirm" class="btn btn-primary">Confirm</button>
        </div>
    </dialog>

    <dialog id="delModal" style="border-radius: 10px; padding: 20px">
        <div style="align-content: center; text-align: center">
            <p style="margin-bottom: 20px">Do you want to delete this event ?</p>
            <button id="delClose" class="btn btn-danger" style="margin-right: 50px">No</button>
            <button id="delConfirm" class="btn btn-primary">Yes</button>
        </div>
    </dialog>


    <div id="calendar" class="text-white"></div>

</x-app-layout>

