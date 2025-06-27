<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Http\Reports\AssistanceGeneralReport;
use App\Http\Reports\GeneralStatisticsReport;

class ReportController extends Controller
{
    public function __construct(
        AssistanceGeneralReport $assistanceGeneralReport,
        GeneralStatisticsReport $generalStatisticsReport
    )
    {
        $this->assistanceGeneralReport = $assistanceGeneralReport;
        $this->generalStatisticsReport = $generalStatisticsReport;
    }

    public function getAssistanceGeneral(Request $request)
    {
        try {
            $data = $this->assistanceGeneralReport->generate($request);
            return $this->responseApi(false, "OK", $data);
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function generateGeneralStatistics(Request $request)
    {
        try {
            $data = $this->generalStatisticsReport->generate($request);
            return $this->responseApi(false, "OK", $data);
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function clasificationPeople(Request $request)
    {
        $post = (object) $request->all();
        dd($post);
    }
}