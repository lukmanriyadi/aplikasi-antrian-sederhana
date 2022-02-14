<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreQueueRequest;
use App\Http\Requests\UpdateQueueRequest;


class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.queue.index',[
            'queues' => Queue::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('landing.index',[
            'services' => Service::where('status', 1)->get(),
            'queues' => Queue::where('status', 'Waiting')->with('service')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQueueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQueueRequest $request)
    {
        $service = Service::where('id',$request->service_id)->first();
        $countQueue = Queue::where('service_id', $request->service_id)->count();
        $data = [
            'service_id' => $request->service_id,
            'number' => $service->code.$countQueue+1,
            'status' => 'Waiting',
        ];
        Queue::create($data);
        $pdf = Pdf::loadView('landing.print', $data);
        $pdf->save(storage_path('/app/public/queue/').$data['number'].'.pdf');
        return $pdf->stream();
        // return redirect()->to('/');
        // return $this->print($data);
    }

    public function print($data)
    {
        $pdf = Pdf::loadView('landing.print', $data);
        $pdf->save(storage_path('/app/public/queue/').$data['number'].'.pdf');
        return $pdf->stream();
        // return $pdf->download($data['number'].'.pdf');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function show(Queue $queue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQueueRequest  $request
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQueueRequest $request, Queue $queue)
    {
        $data = ['status' => 'Completed'];
        $queue->update($data);
        return redirect()->to('/officer/queue');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queue $queue)
    {
        //
    }
}