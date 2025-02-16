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

    public function assignPeople(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $people = People::find($post->people_id);
            if($people == null) throw new Exception("La persona no existe");

            ConnectionMember::where('people_id', $post->people_id)->delete();

            $entity = new ConnectionMember;
            $entity->people_id = $post->people_id;
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al agregar al miembro al conexiones, comuniquese con el administrador del sistema");
            }
            Log::save("Agregaron a un nuevo miembro a conexiones [Persona: ".$people->phone."]");
            return $this->responseApi(false, "Miembro asociado al conexiones exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }
}