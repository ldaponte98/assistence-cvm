<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

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

    public function create(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = new People;
            $entity->created_by_id = session("id");
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al almacenar el registro, comuniquese con el administrador del sistema");
            }
            Log::save("Registro una nueva persona en la base de datos [".$post->phone."]");
            return $this->responseApi(false, "Registro almacenado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = People::find($post->id);
            if($entity == null) throw new Exception("El registro no existe");
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al actualizar el registro, comuniquese con el administrador del sistema");
            }
            Log::save("Actualizo información de una persona en la base de datos [".$post->phone."]");
            return $this->responseApi(false, "Registro actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }
}