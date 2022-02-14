<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\Counter;

use App\Models\Service;
use App\Models\ServiceUser;

use Illuminate\Support\Collection;
use function PHPUnit\Framework\isEmpty;

class OfficerService
{
    public function getServiceHandled($route = 'queue')
    {
        $serviceHandled = ServiceUser::where('user_id', auth()->user()->id)->get();
        if($route == 'queue'){
            if($serviceHandled->isEmpty()){
                abort(403, 'Officer Doesnt Assign The Service(s)');
            }
        }
        return $serviceHandled;
    }
    public function getServiceNotHandled(Collection $servicesHandled)
    {
        $servicesNotHandled = Service::whereNotIn('id', $servicesHandled)->get();
        return $servicesNotHandled;
    }

    public function getCounterHandled($route = 'queue')
    {
        $counter = Counter::where('user_id', auth()->user()->id)->first();
        if($route == 'queue'){
            if(!$counter){
                abort(403, 'Officer Doesnt Assign the Counter');
            }
        }
        return $counter;
    }
    public function getCounterNotHandled()
    {
        $counter = Counter::where('status', 0)->whereNull('user_id')->get();
        return $counter;
    }

    public function getEligibleQueue(Collection $servicesHandled)
    {
        //get the alredy processing queue if exist
        $queue = Queue::whereIn('service_id', $servicesHandled->pluck('service_id'))
        ->where('status', 'Processing')
        ->where('user_id', auth()->user()->id)
        ->orderBy('created_at')
        ->first();
        
        //but if empty get new one queue
        if(empty($queue)){
            $queue = Queue::whereIn('service_id', $servicesHandled->pluck('service_id'))
            ->where('status', 'Waiting')
            ->orderBy('created_at')
            ->first();
            if (!empty($queue)){
                $queue->update([
                    'status' => 'Processing',
                    'user_id' => auth()->user()->id,
                ]);
            }
        }
        return $queue;
    }
}