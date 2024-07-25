<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-gray-200 leading-tight">
            {{ __('Rendez-vous disponibles') }}
        </h2>
    </x-slot>

    <div class="table-responsive">
        <table class="table text-center">
            <thead>
            <tr>
                <th> </th>
                <th scope="col">Name</th>
                <th scope="col">Day</th>
                <th scope="col">Start</th>
                <th scope="col">End</th>
                <th scope="col">Contact</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <th scope="row"> </th>
                    <td>{{ $event->user->name }}</td>
                    <td>{{ $event->start[0] }}</td>
                    <td>{{ $event->start[1] }}</td>
                    <td>{{ $event->end[1] }}</td>
                    <td>Mark</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>

