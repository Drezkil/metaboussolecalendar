<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-gray-200 leading-tight">
            {{ __('Rendez-vous disponibles') }}
        </h2>
    </x-slot>

    <div class="container text-center">
        <div class="row row-cols-auto">
            <div class="col">Name</div>
            <div class="col">Day</div>
            <div class="col">Start</div>
            <div class="col">End</div>
            <div class="col">Contact</div>
        </div>
    </div>

</x-app-layout>

