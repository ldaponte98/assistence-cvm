<?php
namespace App\Http\Reports;

use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\ConectionGroupLeader;
use App\Shared\PeopleType;
use App\Shared\ProfileID;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

class AssistanceGeneralReport extends Report
{
    public function generate($request)
    {
        $post = $request->all();        
        if($post == null) throw new Exception("Error de información enviada");
        $post = (object) $post;
        if($this->isEmpty($post->start)) throw new Exception("Debe enviar una fecha inicial valida para filtrar el reporte");
        if($this->isEmpty($post->end)) throw new Exception("Debe enviar una fecha final valida para filtrar el reporte");
        $conditions = " AND e.start BETWEEN '".$post->start.":00' AND '".$post->end.":59'";
        if(!$this->isEmpty($post->type)) $conditions .= " AND e.type = '".$post->type."'";
        if(!$this->isEmpty($post->red)) $conditions .= " AND e.red = '".$post->red."'";
        if(session('red') != null) $conditions .= " AND e.red = '".session('red')."'";

        if(session('profile_id') == ProfileID::SEGMENT_LEADER) $conditions .= " AND cgsl.people_id = ".session('people_id')."";
        if(session('profile_id') == ProfileID::LEADER) $conditions .= " AND cgl.people_id = ".session('people_id')."";
        $sql = "SELECT 
        e.id as event_id,
        e.title,
        DATE_FORMAT(e.start, '%Y-%m-%d %H:%i') as start,
        DATE_FORMAT(e.end, '%Y-%m-%d %H:%i') as end,
        CASE WHEN e.managed = 1 THEN 'Finalizada' ELSE 'Pendiente' END AS assistance,
        count(a.id) as total, 
        count(a.id) - sum(if(a.attended = 1, 1, 0)) as not_attendeds, 
        sum(if(a.attended = 1, 1, 0)) as attendeds, 
        sum(if(a.isNew = 1, 1, 0)) as news
        FROM event e 
        LEFT JOIN event_assistance a ON e.id = a.event_id
        LEFT JOIN conection_group_segment_leaders cgsl ON cgsl.conection_group_id = e.conection_group_id
        LEFT JOIN conection_group_leaders cgl ON cgl.conection_group_id = e.conection_group_id
        WHERE e.status = 1
        $conditions
        GROUP BY 1, 2, 3, 4, 5
        ORDER BY e.start ASC";
        return DB::select($sql);
    }
}