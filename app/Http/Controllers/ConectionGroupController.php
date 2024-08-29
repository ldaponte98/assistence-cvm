<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\ConectionGroupSegmentLeader;
use App\Models\ConectionGroupAssistant;
use App\Models\ConectionGroupLeader;
use App\Shared\PeopleType;
use App\Shared\ProfileID;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

class ConectionGroupController extends Controller
{
    public function all()
    {
        $groups = [];
        $profile_id = session('profile_id');
        $red = session('red');
        if($profile_id == ProfileID::SUPER_ADMIN) $groups = ConectionGroup::all();
        if($profile_id == ProfileID::RED_AUDITOR || $profile_id == ProfileID::SEGMENT_LEADER) $groups = ConectionGroup::all()->where('red', $red);
        foreach ($groups as $group) {
            $group->segment_leaders = $group->getSegmentLeaders();
            $group->leaders = $group->getLeaders();
        }
        return view('conection-group.all.all', compact(['groups'])); 
    }

    public function settings($id = null)
    {
        $entity = $id == null ? new ConectionGroup : ConectionGroup::find($id);
        if($entity->id != null){
            $entity->segment_leaders = $entity->getSegmentLeaders();
            $entity->leaders = $entity->getLeaders();
        }
        return view("conection-group.form.form", compact(['entity']));
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
            $entity->created_by_id = session('id');
            $entity->neighborhoods = "";
            if($post->check_neighborhoods == 1){
                foreach ($post->neighborhoods as $item) {
                    if($entity->neighborhoods != "") $entity->neighborhoods .= "%%";
                    $entity->neighborhoods .= $item;
                }
            }
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
            $entity->neighborhoods = "";
            if($post->check_neighborhoods == 1){
                foreach ($post->neighborhoods as $item) {
                    if($entity->neighborhoods != "") $entity->neighborhoods .= "%%";
                    $entity->neighborhoods .= $item;
                }
            }
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
        $profile_id = session("profile_id");
        $data = ConectionGroup::where('status', 1);

        if($profile_id == ProfileID::SUPER_ADMIN and $red != null){
            $data = $data->where('red', $red);
        }

        if($profile_id == ProfileID::RED_AUDITOR){
            $data = $data->where('red', session('red'));
        }

        if($profile_id == ProfileID::SEGMENT_LEADER){
            $relations = ConectionGroupSegmentLeader::where('people_id', session('people_id'))
            ->get(['conection_group_id']);
            $data = $data->where('red', session('red'))
                             ->whereIn('id', $relations);
        }

        if($profile_id == ProfileID::LEADER){
            $relations = ConectionGroupLeader::where('people_id', session('people_id'))
            ->get(['conection_group_id']);
            $data = $data->where('red', session('red'))
                             ->whereIn('id', $relations);
        }

        $data = $data->get();
        return $this->responseApi(false, "OK", $data);
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

    public function removePeople($people_id, $conection_group_id)
    {
        try {
            ConectionGroupAssistant::where('conection_group_id', $conection_group_id)
            ->where('people_id', $people_id)
            ->delete();
            return $this->responseApi(false, "Participante eliminado del grupo exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function assignPeople(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $group = ConectionGroup::find($post->group_id);
            if($group == null) throw new Exception("El grupo no existe");
            $people = People::find($post->people_id);
            if($people == null) throw new Exception("La persona no existe");

            ConectionGroupAssistant::where('people_id', $post->people_id)->delete();

            $entity = new ConectionGroupAssistant;
            $entity->conection_group_id = $post->group_id;
            $entity->people_id = $post->people_id;
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al agregar al asistente al grupo de conexión, comuniquese con el administrador del sistema");
            }
            Log::save("Agregaron a un nuevo integrante a un grupo [Grupo ID: ".$group->id."][Persona: ".$people->phone."]");
            return $this->responseApi(false, "Asistente asociado al grupo de conexión exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }
}