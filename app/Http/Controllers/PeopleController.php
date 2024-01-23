<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{
    public function all()
    {
        $peoples = People::all();
        return view('people.all.all', compact(['peoples'])); 
    }

    public function findByCharacters($characters)
    {
        $result = [];
        $characters = strtoupper($characters);
        if(strlen($characters) > 3){
            $sql = "SELECT CONCAT(fullname, ' ', lastname, ' (Tel: ', phone, ')') as info FROM people 
            WHERE UPPER(document) LIKE '%$characters%'
            OR UPPER(fullname) LIKE '%$characters%'
            OR UPPER(lastname) LIKE '%$characters%'
            OR UPPER(phone) LIKE '%$characters%'
            OR UPPER(email) LIKE '%$characters%'";
            $result = DB::select($sql);
        }
        return response()->json($result);
    }
}