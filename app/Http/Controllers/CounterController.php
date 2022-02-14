<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCounterRequest;
use App\Models\Queue;
use App\Models\Counter;
use App\Http\Requests\UpdateCounterRequest;
use App\Services\CounterService;

class CounterController extends Controller
{
    protected $counterService;
 	public function __construct()
    {
		$this->counterService = new CounterService();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counters = Counter::all();
        $status =   Queue::where('status', 'Processing')->get(['id','service_id','user_id']);
        return view('landing.monitor',[
            'counters' => $counters,
            'status' => $status
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.counter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCounterRequest $request)
    {
        Counter::create($request->validated());
        return redirect()->to('/admin/counter')->with('status', 'Your Counter Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function show(Counter $counter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function edit(Counter $counter)
    {
       return view('admin.counter.edit',[
           'counter' => $counter
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCounterRequest $request, Counter $counter)
    {
        return $this->counterService->updateCounter($request, $counter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->to('/admin/counter')->with('status', 'Your Counter Successfully Deleted');
    }
}