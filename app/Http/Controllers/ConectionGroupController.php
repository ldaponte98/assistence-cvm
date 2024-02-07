<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\ConectionGroupLeader;
use App\Shared\PeopleType;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

class ConectionGroupController extends Controller
{
    public function all()
    {
        $groups = ConectionGroup::all();
        foreach ($groups as $group) {
            $group->segment_leaders = $group->getSegmentLeaders();
            $group->leaders = $group->getLeaders();
        }
        return view('conection-group.all.all', compact(['groups'])); 
    }

    public function create(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = new ConectionGroup;
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al almacenar el grupo de conexión, comuniquese con el administrador del sistema");
            }
            $this->saveLeaders(PeopleType::SEGMENT_LEADER, $entity->id, $post->segment_leaders);
            $this->saveLeaders(PeopleType::LEADER, $entity->id, $post->leaders);
            Log::save("Registro un grupo de conexión en la base de datos [Red: ".$post->red."][Nombre: ".$post->name."]");
            return $this->responseApi(false, "Grupo de conexión almacenado exitosamente");
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
            $entity = ConectionGroup::find($post->id);
            if($entity == null) throw new Exception("El registro no existe");
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al actualizar el grupo de conexión, comuniquese con el administrador del sistema");
            }
            $this->saveLeaders(PeopleType::SEGMENT_LEADER, $entity->id, $post->segment_leaders);
            $this->saveLeaders(PeopleType::LEADER, $entity->id, $post->leaders);
            Log::save("Actualizo información de un grupo de conexión en la base de datos [Red: ".$post->red."][Nombre: ".$post->name."]");
            return $this->responseApi(false, "Grupo de conexión actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function saveLeaders($leader_type, $conection_group_id, $ids)
    {
        $table = $leader_type == PeopleType::LEADER ? "conection_group_leaders" : "conection_group_segment_leaders";
        $sql = "DELETE FROM $table WHERE conection_group_id = $conection_group_id";
        DB::delete($sql);
        foreach ($ids as $id) {
            DB::table($table)->insert(
                [
                    'people_id' => $id, 
                    'conection_group_id' => $conection_group_id
                ]
            );
        }
    }

    public function findByRed($red)
    {
        return $this->responseApi(false, "OK", ConectionGroup::all()->where('red', $red)->where('status', 1));
    }

    public function meGroup()
    {
        $people_id = session("people_id");
        $group = null;
        $relation = ConectionGroupLeader::where('people_id', $people_id)
                                         ->where('status', 1)
                                         ->first();

        if($relation != null) $group = $relation->conection_group;
        return view('conection-group.me-group.me-group', compact(['group'])); 
    }
}