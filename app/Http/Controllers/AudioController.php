<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Support\Str;
use App\Services\AudioService;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreAudioRequest;

class AudioController extends Controller
{
	protected $audioService;
 	public function __construct()
    {
		$this->audioService = new AudioService();
	}
    public function index()
    {
		$audioHaventPlayed = $this->audioService->getAudioHaventPlayed();
		//get list audio to be played base on queue number else return null
		$listAudio = $this->audioService->getListAudioPlayed($audioHaventPlayed);

        return view('landing.audio',[
            'audios' => $audioHaventPlayed,
            'sound' => $listAudio,
        ]);
    }

    public function store(StoreAudioRequest $request)
    {
        Audio::create($request->validated());
        return redirect('officer/queue?new=1');
    }

	public function update(Audio $audio)
	{
		$audio->update(['status' => 'Complete']);
		return redirect('/audio');
	}
}