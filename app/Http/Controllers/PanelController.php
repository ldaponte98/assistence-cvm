<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Shared\ProfileID;
use Exception;

class PanelController extends Controller
{
    public function index()
    {
        $profile_id = session("profile_id");
        $events = Event::where('status', 1);

        if($profile_id == ProfileID::SEGMENT_LEADER){
            $events = $events->where('created_by_id', session('id'))
                             ->where('red', session('red'));
        }

        if($profile_id == ProfileID::LEADER){
            $events = $events->where('created_by_id', session('id'))
                             ->where('red', session('red'));
        }

        $events = $events->orderBy('start', 'asc')->get();

        $filters = [];
        foreach ($events as $event) {
            if($event->validForSettings()) $filters[] = $event;
        }
        $events = $filters;
        return view('site.panel', compact(['events'])); 
    }
}