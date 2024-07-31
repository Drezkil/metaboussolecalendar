<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {

        $date = date('Y-m-d H:i:s');
        $auth = Auth::id();

        $events = $auth ?
            Event::query()->where('id_user', '!=', $auth)->where('end', '>' , $date )->get() :
            Event::get();

        foreach ($events as $event) {
            $event->start = explode(' ', $event->start);
            $event->end = explode(' ', $event->end);
        }


        $data = [
            'events' => $events,
        ];

        return view('urgent.index', $data);
    }

    public function show($id_user = null)
    {

        $events = $id_user ?
            Event::where('id_user', $id_user)->orderBy('id', 'asc')->get() :
            Event::all();


        return $events;
    }

    public function store(EventRequest $eventRequest)
    {


            $event = new Event;

            $event->title = $eventRequest->title;
            $event->start = $eventRequest->start;
            $event->end = $eventRequest->end;
            $event->id_user = $eventRequest->id_user;

            $event->save();

    }

    public function storeEveryday(EventRequest $eventRequest)
    {

        $start = new \DateTime($eventRequest->start);

        $year = (int) $start->format('Y');
        $nextYear = $year + 1;

        $endEv = new \DateTime($eventRequest->end);
        $interval = new \DateInterval('P1D');
        $end = new \DateTime("$nextYear-01-01 00:00");

        while ($start < $end) {
            $event = new Event;

            $event->title = $eventRequest->title;
            $event->start = $start;
            $event->end = $endEv;
            $event->id_user = $eventRequest->id_user;

            $event->save();



            $start->add($interval);
            $endEv->add($interval);
        }

    }

    public function storeWeekly(EventRequest $eventRequest)
    {

        $start = new \DateTime($eventRequest->start);

        $year = (int) $start->format('Y');
        $nextYear = $year + 1;

        $endEv = new \DateTime($eventRequest->end);
        $interval = new \DateInterval('P7D');
        $end = new \DateTime("$nextYear-01-01 00:00");

        while ($start < $end) {
            $event = new Event;

            $event->title = $eventRequest->title;
            $event->start = $start;
            $event->end = $endEv;
            $event->id_user = $eventRequest->id_user;

            $event->save();



            $start->add($interval);
            $endEv->add($interval);
        }

    }

    public function update(EventRequest $eventRequest, Event $event)
    {
        $event->update([
            'title' => $eventRequest->title,
            'start' => $eventRequest->start,
            'end' => $eventRequest->end
        ]);

    }

    public function destroy(Event $event)
    {
        $event->delete();
    }
}

