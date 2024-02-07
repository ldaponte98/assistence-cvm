<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\Event;
use App\Models\EventAssistance;
use App\Models\ConectionGroupAssistant;
use App\Models\ConectionGroupSegmentLeader;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use App\Shared\ProfileID;
use App\Shared\EventType;
use Exception;

class EventController extends Controller
{
    public function find()
    {
        $profile_id = session("profile_id");
        $events = Event::where('status', 1);
        if($profile_id == ProfileID::RED_AUDITOR){
            $events = $events->where('red', session('red'));
        }

        if($profile_id == ProfileID::SEGMENT_LEADER){
            $relations = ConectionGroupSegmentLeader::where('people_id', session('people_id'))
            ->get(['conection_group_id']);
            $events = $events->where('red', session('red'))
                             ->whereIn('conection_group_id', $relations);
        }
        $events = $events->get();
        return $this->responseApi(false, "OK", $events);
    }

    public function create(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $dateStart = date('Y-m-d', strtotime($post->start));
            $dateEnd = date('Y-m-d', strtotime($post->end));
            $validDates = false;
            while ($dateStart <= $dateEnd) {
                $dayWeek = $this->getDayWeek($dateStart);
                if(in_array("all", $post->days) || in_array($dayWeek, $post->days)){
                    $validDates = true;
                    $timeStart = date('H:i:s', strtotime($post->start));
                    $timeEnd = date('H:i:s', strtotime($post->end));
                    $entity = new Event;
                    $entity->fill($request->all());
                    $entity->validate();
                    $entity->start = $dateStart . " " . $timeStart;
                    $entity->end = $dateStart . " " . $timeEnd;
                    $entity->created_by_id = session("id");
                    if(!$entity->save()){
                        throw new Exception("Ocurrio un error interno al programar el evento, comuniquese con el administrador del sistema");
                    }
                }
                $dateStart = date('Y-m-d', strtotime($dateStart . " +1 days"));
            }
            if(!$validDates) throw new Exception("No se pudieron programar eventos validos porque la parametrización de rancgo de fechas y dias de evento no coincidieron en ningun escenario");
            Log::save("Registro un evento en la base de datos [Evento: ".$post->title."] [Inicio: ".$post->start."][Fin: ".$post->end."]");
            return $this->responseApi(false, "Evento programado exitosamente");
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
            $entity = Event::find($post->id);
            if($entity == null) throw new Exception("El evento no existe");
            $dateStart = date('Y-m-d', strtotime($post->start));
            $dateEnd = date('Y-m-d', strtotime($post->end));
            if($dateStart != $dateEnd) throw new Exception("No se puede modificar el evento porque las fechas deben ser el mismo dia");
            $entity->fill($request->all());
            $entity->validate();
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al actualizar el evento, comuniquese con el administrador del sistema");
            }
            Log::save("Actualizo información de un evento en la base de datos [Evento: ".$post->title."] [Inicio: ".$post->start."][Fin: ".$post->end."]");
            return $this->responseApi(false, "Evento actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function cancel(Request $request, $id)
    {
        try{
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = Event::find($id);
            if($entity == null) throw new Exception("El evento no existe");
            if($entity->created_by_id != session("id") and session('profile_id') != ProfileID::SUPER_ADMIN) throw new Exception("El evento no puede ser cancelado por otro usuario que no sea el creador del evento.");
            $entity->status = 0;
            $entity->observations = $post->observations;
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al cancelar el evento, comuniquese con el administrador del sistema");
            }
            Log::save("Cancelo un evento en la base de datos [Evento: ".$entity->title."] [Inicio: ".$entity->start."][Fin: ".$entity->end."]");
            return $this->responseApi(false, "Evento cancelado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function settings($id)
    {
        $event = Event::find($id);
        if($event == null) throw new Exception("El evento no existe");
        return view("event.settings.settings", compact(['event']));
    }

    public function saveAssistance(Request $request)
    {
        try{
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $event = Event::find($post->event_id);
            if($event == null) throw new Exception("El evento no existe");
            if(!$event->validForSettings()) throw new Exception("Este evento esta por fuera de las fechas de toma de asistencia, por favor comunicate con el administrador del sistema.");
            if(!$event->validForAssistance(session('profile_id'), session('people_id'))) throw new Exception("Usted no cuenta con los permisos suficientes para tomar la asistencia del evento.");
            $event->managed = 1;
            $event->observations = $post->observations;
            if(!$event->save()){
                throw new Exception("Ocurrio un error interno al actualizar el evento, comuniquese con el administrador del sistema");
            }
            if (isset($post->assistants)) {
                foreach ($post->assistants as $element) {
                    $element = (object) $element;
                    $assistant = EventAssistance::where('event_id', $event->id)
                                                ->where('people_id', $element->id)
                                                ->first();
                    if($assistant == null){
                        $assistant = new EventAssistance(); 
                    }
                    $assistant->event_id = $event->id;
                    $assistant->people_id = $element->id;
                    $assistant->attended = $element->attended == "true" ? 1 : 0;
                    $assistant->isNew = $element->isNew == "true" ? 1 : 0;
                    $assistant->save();

                    if($event->type == EventType::CONECTIONS_GROUP){
                        $in_group = ConectionGroupAssistant::where('conection_group_id', $event->conection_group_id)
                                                ->where('people_id', $assistant->people_id)
                                                ->first();
                        if($in_group == null){
                            $in_group = new ConectionGroupAssistant;
                            $in_group->conection_group_id = $event->conection_group_id;
                            $in_group->people_id = $assistant->people_id;
                            $in_group->save();
                        }
                        $sql = "UPDATE conection_group_assistant SET status = 0 WHERE people_id = " . $assistant->people_id . " AND conection_group_id <> " . $event->conection_group_id;
                        DB::update($sql);
                    }
                }
            }
            Log::save("Toma de asistencia de un evento en la base de datos [Evento: ".$event->title."] [Inicio: ".$event->start."][Fin: ".$event->end."]");
            return $this->responseApi(false, "Asistencia registrada exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function findAssistants($event_id)
    {
        $event = Event::find($event_id);
        if($event == null) throw new Exception("El evento no existe");
        $result = [];
        if($event->type == EventType::CONECTIONS_GROUP){
            $in_group = ConectionGroupAssistant::where('status', 1)
                                               ->where('conection_group_id', $event->conection_group_id)
                                               ->get();
            foreach ($in_group as $assistantOld) {
                $assistantOld = (object) $assistantOld;
                $result[] = (object) [
                    "id" => $assistantOld->people_id,
                    "name" => $assistantOld->people->names(),
                    "attended" => false,
                    "isNew" => false
                ];
            }
            $assistantsPrev = EventAssistance::where('event_id', $event->id)->get();
            foreach ($assistantsPrev as $prev) {
                $prev = (object) $prev;
                $insert = true;
                $data = (object) [
                    "id" => $prev->people_id,
                    "name" => $prev->people->names(),
                    "attended" => $prev->attended == 1,
                    "isNew" => $prev->isNew == 1
                ];
                $index = 0;
                foreach ($result as $in_group_element) {
                    $in_group_element = (object) $in_group_element;
                    if($in_group_element->id == $data->id) {
                        $insert = false;
                        $result[$index] = $data;
                    }
                    $index++;
                }
                if($insert){
                    $result[] = $data;
                }
            }
        }
        return $this->responseApi(false, "OK", $result);
    }
}