<?php
namespace App\Http\Reports;

use App\Models\People;
use App\Models\ConectionGroup;
use App\Models\ConectionGroupLeader;
use App\Models\EventAssistance;
use App\Shared\PeopleType;
use App\Shared\EventType;
use App\Shared\ProfileID;
use Illuminate\Support\Facades\DB;
use App\Shared\Log;
use Exception;

class GeneralStatisticsReport extends Report
{
    public function __construct(
        AssistanceGeneralReport $assistanceGeneralReport,
        ActiveAssistantReport $activeAssistantReport
    )
    {
        $this->assistanceGeneralReport = $assistanceGeneralReport;
        $this->activeAssistantReport = $activeAssistantReport;
    }
    public function generate($request)
    {
        $result = $this->assistanceGeneralReport->generate($request);
        $resultActives = $this->activeAssistantReport->generate($request);
        return (object) [
            'detailsExtractorActives' => $resultActives,
            'totalByDate' => $this->reportGeneralByDate($result),
            'extractorActives' => $this->reportExtractorActives($resultActives)
        ];
    }

    public function reportGeneralByDate($result)
    {
        $report = [];
        foreach ($result as $item) {
            if($item->assistance == "Finalizada"){
                $item = (object) $item;
                $date = date('Y-m-d', strtotime($item->start));
                $index = $this->existInArray($report, 'date', $date);
                $total = $this->totalOldsByEvent($item->event_id, $date);
                if($index == -1){                
                    $report[] = [
                        'date' => $date,
                        'total' => $total, 
                        'attendeds' => $item->attendeds, 
                        'news' => $item->news
                    ];
                }else{
                    $report[$index]['total'] += $total;
                    $report[$index]['attendeds'] += $item->attendeds;
                    $report[$index]['news'] += $item->news;
                }
            }
        }
        return $report;
    }

    public function reportExtractorActives($result)
    {
        $response = (object)[
            'assistance_zero' => 0,
            'assistance_only_one' => 0,
            'total' => count($result),
            'real' => 0
        ];

        foreach ($result as $item) {
            $item = (object) $item;
            if($item->attends == 0) $response->assistance_zero++;
            if($item->attends == 1) $response->assistance_only_one++;
        }
        $response->real = $response->total - $response->assistance_zero - $response->assistance_only_one;
        return $response;
    }

    public function existInArray($array, $property, $value)
    {
        $pos = 0;
        $result = -1;
        foreach ($array as $item) {
            if($item[$property] == $value){
                $result = $pos;
            } 
            $pos++;
        }
        return $result;
    }

    public function totalOldsByEvent($event_id, $date)
    {
        return DB::table('event_assistance as ea')
            ->join('people as p', 'p.id', '=', 'ea.people_id')
            ->where('ea.event_id', $event_id)
            ->where('p.created_at', '<=', "$date 23:59:59")
            ->count();
    }
}