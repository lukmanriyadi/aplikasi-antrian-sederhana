<?php

namespace App\Services;

use App\Models\Audio;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class AudioService
{
    
    public function getAudioHaventPlayed()
    {
        $audio = Audio::where('status', 'Waiting')->orderBy('created_at')->first();
        return $audio;
    }

    public function getListAudioPlayed($audio)
    {
        //check if audio havent played is empty
        $listAudio = null;
        if ($audio) {
            //create list of audio from the queue number
            $code = explode('.', $audio['queue_number'])[0];
            $urut = explode('.', $audio['queue_number'])[1];
            $terbilang = $this->terbilang($urut);
            $terbilangCounter = $this->terbilang($audio['counter_number']);
            $listAudio = new Collection([
                'intro' => ['in', 'nomor-urut'],
                'code' => str_split($code),
                'urutan' => (Str::contains($terbilang, ' ') ? explode(' ', $terbilang) : $terbilang),
                'konter' => 'konter',
                'number' => (Str::contains($terbilangCounter, ' ') ? explode(' ', $terbilangCounter) : $terbilangCounter),
                'outro' => 'out'
                // 'closing' => ['konter', (Str::contains($terbilangCounter, ' ') ? explode(' ', $terbilangCounter) : $terbilangCounter) , 'out']
            ]);
            // dd($listAudio);
        }

        return $listAudio;
    }

    private function penyebut(int $nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    private function terbilang(int $nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }
}