<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ConectionGroupAssistant;
use App\Models\ConnectionMember;
use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use App\Shared\ApplicationWebhookHandler;
use App\Shared\PeopleStatus;
use Exception;

class PeopleController extends Controller
{
    public function all()
    {
        $peoples = People::all();
        return view('people.all.all', compact(['peoples'])); 
    }

    public function findByPhone($phone)
    {
        $people = People::where('phone', $phone)->first();
        $message = $people != null ? "OK" : "Persona no existe por telefono enviado";
        return $this->responseApi($people == null, $message, $people);
    }

    public function findByDocument($value)
    {
        $people = People::where('document', $value)->first();
        $message = $people != null ? "OK" : "Persona no existe";
        return $this->responseApi($people == null, $message, $people);
    }

    public function findByCharacters($characters, $type = null)
    {
        $result = [];
        $characters = strtoupper($characters);
        $conditions = "";
        if($type != null){
            $array = explode(",", $type);
            $in = "";
            $cont = 0;
            foreach ($array as $_type) {
                if($cont != 0) $in .= ",";
                $in .= "'$_type'";
                $cont++;
            }
            $conditions = $type != null ? " AND type IN($in) " : "";
        }
        if(strlen($characters) > 3){
            $sql = "SELECT CONCAT(fullname, ' ', lastname, ' (Tel: ', phone, ')') as info FROM people 
            WHERE 1 = 1 
            $conditions
            AND (UPPER(document) LIKE '%$characters%'
            OR UPPER(fullname) LIKE '%$characters%'
            OR UPPER(lastname) LIKE '%$characters%'
            OR UPPER(phone) LIKE '%$characters%'
            OR UPPER(email) LIKE '%$characters%')";
            $result = DB::select($sql);
        }
        foreach ($result as $people) {
            $people = (object) $people;
            $people->info = $this->stripAccents($people->info);
        }
        return response()->json($result);
    }

    function stripAccents($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    public function create(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = new People;
            $entity->created_by_id = session("id");
            $entity->cre = $post->identity->
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al almacenar el registro, comuniquese con el administrador del sistema");
            }
            if(isset($post->conection_group_id)){
                $this->registerPeopleInGroup($post->conection_group_id, $entity->id);
            }
            
            if(isset($post->member_connections)){
                $this->registerPeopleInConnections($entity->id);
            }
            Log::save("Registro una nueva persona en la base de datos [".$post->phone."]");
            return $this->responseApi(false, "Registro almacenado exitosamente", $entity);
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function registerPeopleInGroup($conection_group_id, $people_id)
    {
        $register = new ConectionGroupAssistant;
        $register->conection_group_id = $conection_group_id;
        $register->people_id = $people_id;
        $register->save();
    }

    public function registerPeopleInConnections($people_id)
    {
        $register = new ConnectionMember;
        $register->people_id = $people_id;
        $register->save();
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
            ApplicationWebhookHandler::run(ApplicationWebhookHandler::UPDATE_PEOPLE, $entity);
            return $this->responseApi(false, "Registro actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function createExternal(Request $request){
        try {
            $post = $request->all();    
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = new People;
            $entity->created_by_id = 0;
            $entity->application_created_by = $post->identity->app_id;
            $entity->status = PeopleStatus::ACTIVE;
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al almacenar el registro, comuniquese con el administrador del sistema");
            }
            Log::save("Registro una nueva persona en la base de datos [".$post->phone."] desde la app id: " . $post->identity->app_id);
            return $this->responseApi(false, "Registro almacenado exitosamente", $entity);
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function history(Request $request) {
        $people = null;
        $error = null;
        try {
            $data = [];
            $post = $request->all();
            if ($post) {
                $post = (object) $post;
                $people = $this->getPeopleFromText($post->people, true);
            }
        } catch (Exception $e) {
            $people = null;
            $error = $e->getMessage();
        }
        return view("people.history.history", compact(["people", "error"]));
    }
}