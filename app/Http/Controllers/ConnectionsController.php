<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ConnectionMember;
use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

class ConnectionsController extends Controller
{
    public function members()
    {
        $members = ConnectionMember::all();
        $peoples = [];
        foreach ($members as $member) {
            $peoples[] = $member->people;
        }
        return view('connections.all.all', compact(['peoples'])); 
    }
}