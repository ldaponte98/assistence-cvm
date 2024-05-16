<?php
namespace App\Http\Reports;

use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\ConectionGroupLeader;
use App\Shared\PeopleType;
use App\Shared\EventType;
use App\Shared\ProfileID;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

class ActiveAssistantReport extends Report
{
    public function generate($request)
    {
        $post = $request->all();
        if($post == null) throw new Exception("Error de información enviada");
        $post = (object) $post;
        if($this->isEmpty($post->start)) throw new Exception("Debe enviar una fecha inicial valida para filtrar el reporte");
        if($this->isEmpty($post->end)) throw new Exception("Debe enviar una fecha final valida para filtrar el reporte");
        $conditions = " WHERE e.start BETWEEN '".$post->start.":00' AND '".$post->end.":59'";
        $joins = "";
        if(!$this->isEmpty($post->type)) $conditions .= " AND e.type = '".$post->type."'";
        if(!$this->isEmpty($post->red)) $conditions .= " AND e.red = '".$post->red."'";
        if($post->type == EventType::CONECTIONS_GROUP){
            if(!$this->isEmpty($post->conection_group_id)) $conditions .= " AND e.conection_group_id = ".$post->conection_group_id;
        }
        if(session('red') != null) $conditions .= " AND cg.red = '".session('red')."'";

        if(session('profile_id') == ProfileID::SEGMENT_LEADER and ($post->type == EventType::CONECTIONS_GROUP or $this->isEmpty($post->type))){
            $joins .= " INNER JOIN conection_group_segment_leaders cgsl ON cgsl.conection_group_id = e.conection_group_id";
            $conditions .= " AND cgsl.people_id = ".session('people_id')."";
        } 

        if(session('profile_id') == ProfileID::LEADER and ($post->type == EventType::CONECTIONS_GROUP or $this->isEmpty($post->type))){
            $joins .= " INNER JOIN conection_group_leaders cgl ON cgl.conection_group_id = e.conection_group_id";
            $conditions .= " AND cgl.people_id = ".session('people_id')."";
        } 
        $conection_group_type = EventType::CONECTIONS_GROUP;
        $sql = "SELECT 
        distinct(cga.people_id) as people_id, 
        p.fullname as assistant,
        SUM(CASE WHEN a.attended = 1 THEN 1 ELSE 0 END) as attends 
        FROM conection_group_assistant cga 
        LEFT JOIN conection_group cg on cg.id = cga.conection_group_id 
        LEFT JOIN people p on p.id = cga.people_id 
        LEFT JOIN event_assistance a on a.people_id = p.id 
        LEFT JOIN event e on e.id = a.event_id 
        $joins
        $conditions
        GROUP BY 1, 2 
        ORDER BY 3";
        return DB::select($sql);
    }
}