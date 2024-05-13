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

class GeneralStatisticsReport extends Report
{
    public function __construct(
        AssistanceGeneralReport $assistanceGeneralReport
    )
    {
        $this->assistanceGeneralReport = $assistanceGeneralReport;
    }
    public function generate($request)
    {
        $result = $this->assistanceGeneralReport->generate($request);
        $report = (object) [
            'totalByDate' => $this->reportGeneralByDate($result)
        ];
        return $report;
    }

    public function reportGeneralByDate($result)
    {
        $report = [];
        foreach ($result as $item) {
            if($item->assistance == "Finalizada"){
                $item = (object) $item;
                $date = date('Y-m-d', strtotime($item->start));
                $index = $this->existInArray($report, 'date', $date);
                
                if($index == -1){                
                    $report[] = [ 
                        'date' => $date,
                        'total' => $item->total, 
                        'attendeds' => $item->attendeds, 
                        'news' => $item->news
                    ];
                }else{
                    $report[$index]['total'] += $item->total;
                    $report[$index]['attendeds'] += $item->attendeds;
                    $report[$index]['news'] += $item->news;
                }
            }
        }
        return $report;
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
}