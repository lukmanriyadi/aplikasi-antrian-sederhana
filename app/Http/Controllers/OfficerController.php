<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Queue;
use App\Models\Counter;
use App\Models\Service;
use App\Models\ServiceUser;
use App\Services\OfficerService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OfficerController extends Controller
{
    protected $officerService;
    public function __construct()
    {
        $this->officerService = new OfficerService();
    }
    public function index()
    {
        $servicesHandled = $this->officerService->getServiceHandled("index");
        $servicesNotHandled = $this->officerService->getServiceNotHandled($servicesHandled->pluck('service_id'));
        $counterHandled = $this->officerService->getCounterHandled("index");
        $countersNotHandled = $this->officerService->getCounterNotHandled();
        return view('officer.index', [
            'servicesNotHandled' => $servicesNotHandled,
            'servicesHandled' => $servicesHandled,
            'countersNotHandled' => $countersNotHandled,
            'counterHandled' => $counterHandled
        ]);
    }

    public function queue()
    {
        $counter = $this->officerService->getCounterHandled();
        $servicesHandled = $this->officerService->getServiceHandled();
        $queue = $this->officerService->getEligibleQueue($servicesHandled);
        $requestCall = true;
        $active = false;
        if (request('new') == 1) {
            if (!empty($queue)) {
                $requestCall = Audio::where('queue_id', $queue->id)
                    ->where('queue_number', $queue->number)
                    ->where('status', 'Waiting')->get()->isEmpty();
            }
            $active = true;
        }

        return view('officer.queue', [
            'queue' => $queue,
            'counter' => $counter,
            'active' => $active,
            'requestCall' => $requestCall
        ]);
    }
}