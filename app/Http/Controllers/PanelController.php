<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\Event;
use App\Models\ConectionGroupSegmentLeader;
use Illuminate\Support\Facades\DB;
use App\Shared\ProfileID;
use App\Shared\PeopleType;
use Exception;

class PanelController extends Controller
{
    public function index()
    {
        $profile_id = session("profile_id");
        $events = Event::where('status', 1);

        if($profile_id == ProfileID::RED_AUDITOR){
            $events = $events->where('red', session('red'));
        }

        if($profile_id == ProfileID::SEGMENT_LEADER){
            $groups_in_charge = ConectionGroupSegmentLeader::getIdsConectionGroup(PeopleType::SEGMENT_LEADER, session('people_id'));
            $events = $events->where('red', session('red'))
                             ->whereIn('conection_group_id', $groups_in_charge);

        }

        if($profile_id == ProfileID::LEADER){
            $groups_in_charge = ConectionGroupSegmentLeader::getIdsConectionGroup(PeopleType::LEADER, session('people_id'));
            $events = $events->where('red', session('red'))
                             ->whereIn('conection_group_id', $groups_in_charge);
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