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
use App\Shared\PeopleType;
use App\Shared\PeopleStatus;
use App\Http\Services\SendEmailService;
use Exception;

class JobsController extends Controller
{
    private $sendEmailService;

    public function __construct(SendEmailService $sendEmailService)
    {
        $this->sendEmailService = $sendEmailService;
    }

    public function validateBirthday() {
        try{
            Log::save("Ejecutando Job para notifcar cumpleaños");
            $current = date('m-d');
            $peoples = People::where('birthday', '!=', null)
                            ->get();
            $birthdays = [];
            foreach ($peoples as $people) {
                $split = explode("-", $people->birthday);
                $date = $split[1] . "-" . $split[2];
                if ($date == $current) $birthdays[] = $people;
            }

            foreach ($birthdays as $birthdayPeople) {
                $in_group = ConectionGroupAssistant::where('people_id', $birthdayPeople->id)
                                            ->first();        
                if ($in_group != null) {
                    $leaders = $in_group->conection_group->getLeadersFull();
                    foreach ($leaders as $leader) {
                        $data = (object) [
                            "peopleName" => $birthdayPeople->names()
                        ];
                        $to = $leader->email != null ? strtolower($leader->email) : "info.iglesiacvm@gmail.com";
                        $this->sendEmailService->send("NotificateToLeaderBirthday", $to, $data);
                    }
                }
            }
            Log::save("Personas para cumpleaños hoy: ". count($birthdays));
            return $this->responseApi(false, "Job ejecutado exitosamente", $birthdays);
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }
}