<?php

namespace App\Services;

use App\Models\Counter;
use Illuminate\Http\Request;

class CounterService
{
    public function updateCounter(Request $request, Counter $counter)
    {
        if ($request->from == 'officer') {
            return $this->updateCounterByOfficer($request);
        } else if($request->from == 'admin') {
            return $this->updateCounterByAdmin($request, $counter);
        }
    }

    private function updateCounterByOfficer(Request $request)
    {
        //update previous counter to null
        Counter::where('user_id', $request->validated()['user_id'])->update(['status' => 0, 'user_id' => null]);
        
        //get new counter based on request
        $counter = Counter::where('id', $request->validated()['counter_id']);
        $data = [
            'status' => 1,
            'user_id' => $request->validated()['user_id']
        ];
        //update to new counter
        $counter->update($data);
        return redirect()->to('/officer')->with('status', 'Your Counter Successfully Updated');
    }

    private function updateCounterByAdmin(Request $request, Counter $counter)
    {
        $counter->update($request->validated());
        return redirect()->to('/admin/counter')->with('status', 'Your Counter Successfully Updated');
    }
}