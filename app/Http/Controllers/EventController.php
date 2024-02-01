<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use App\Shared\ProfileID;
use Exception;

class EventController extends Controller
{
    public function find()
    {
        $events = Event::where('created_by_id', session('id'))->where('status', 1)->get();
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
}