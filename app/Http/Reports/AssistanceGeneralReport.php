<?php
namespace App\Http\Reports;

use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\ConectionGroupLeader;
use App\Shared\PeopleType;
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
        $sql = "SELECT 
        e.id as event_id,
        e.title,
        DATE_FORMAT(e.start, '%Y-%m-%d %H:%i') as start,
        DATE_FORMAT(e.end, '%Y-%m-%d %H:%i') as end,
        CASE WHEN e.managed = 1 THEN 'Finalizada' ELSE 'Pendiente' END AS assistance,
        count(a.id) as total, 
        count(a.id) - count(a.attended) as not_attendeds, 
        count(a.attended) as attendeds, 
        count(a.isNew) as news
        FROM event e LEFT JOIN event_assistance a ON e.id = a.event_id
        WHERE 1 = 1
        $conditions
        GROUP BY 1, 2, 3, 4, 5
        ORDER BY e.start ASC";
        return DB::select($sql);
    }
}