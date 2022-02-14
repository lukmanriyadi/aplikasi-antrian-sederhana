@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Monitor Audio</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>Called Queue</h2>
                    <table class="table table-bordered table-striped text-center mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Queue Number</th>
                                <th scope="col">Counter</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($audios)
                            <tr>
                                <th>1</th>
                                <td>{{ $audios['queue_number'] }}</td>
                                <td>{{ $audios['counter_name'] }}</td>
                            </tr>
                            @else
                            <tr>
                                <th colspan="3">Kosong</th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    @if ($audios)
                    <form id="formAudio" action="{{ url('/audio/'.$audios->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                    @endif

                    @if (!is_null($sound))
                    @foreach ($sound as $audio)
                    @if (is_array($audio))
                    @foreach ($audio as $a)
                    <audio hidden controls id="{{ $a }}" controlsList="nofullscreen nodownload">
                        <source src="{{ asset('storage/audio/'.$a.'.mp3') }}" type="audio/mpeg">
                        Your browser not support
                    </audio>
                    @endforeach
                    @else
                    <audio hidden controls id="{{ $audio }}" controlsList="nofullscreen nodownload">
                        <source src="{{ asset('storage/audio/'.$audio.'.mp3') }}" type="audio/mpeg">
                        Your browser not support
                    </audio>
                    @endif

                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // const audio1 = document.querySelector('#audio1');
    // const iframe1 = document.querySelector('#iframe1');

    // document.addEventListener("DOMContentLoaded", function(event) {
    //     audio1.setAttribute('hidden','hidden');
    //     iframe1.setAttribute('hidden','hidden');
    //     // iframe1.src = 'https://freesound.org/data/previews/67/67739_7037-lq.mp3';
    //     audio1.play();
    // });

    const list_audio_intro = <?= is_null($sound) ? 'false' : json_encode($sound['intro'])  ?> || null;
    const list_audio_code = <?=is_null($sound) ? 'false' : json_encode($sound['code']) ?> || null ;
    const list_audio_urutan = <?=is_null($sound) ? 'false' : json_encode($sound['urutan'])?> || null;
    const list_audio_konter = <?= is_null($sound) ? 'false' : json_encode($sound['konter']) ?> || null;
    const list_audio_number = <?= is_null($sound) ? 'false' : json_encode($sound['number']) ?> || null;
    const list_audio_outro = <?= is_null($sound) ? 'false' : json_encode($sound['outro']) ?> || null;
        const formAudio = document.querySelector('#formAudio');  
        document.addEventListener("DOMContentLoaded", function(event) {
            if(!list_audio_intro){
                console.log('kosong');
                setTimeout(() => {
                window.location.replace('http://library-queue.test/audio');
                }, 10000);
            }else{
                console.log('ada');
                setTimeout(() => {
                mulai()
                }, 2000);
            }
            
        });

        function mulai()
        {
        //intro
        var totalwaktu = 8568.163;
        document.getElementById(list_audio_intro[0]).pause();
        document.getElementById(list_audio_intro[0]).currentTime=0;
        document.getElementById(list_audio_intro[0]).play();
        totalwaktu=document.getElementById(list_audio_intro[0]).duration*1000;
        //intro - 2
        setTimeout(function() {
        document.getElementById(list_audio_intro[1]).pause();
        document.getElementById(list_audio_intro[1]).currentTime=0;
        document.getElementById(list_audio_intro[1]).play();
        }, totalwaktu);
        totalwaktu=totalwaktu+1000;
        // looping for play code
        list_audio_code.forEach(code => {
        setTimeout(function() {
        document.getElementById(code).pause();
        document.getElementById(code).currentTime=0;
        document.getElementById(code).play();
        }, totalwaktu);
        totalwaktu=totalwaktu+1000;
        });
        
        if(Array.isArray(list_audio_urutan)){
        list_audio_urutan.forEach(urutan => {
        setTimeout(function() {
        document.getElementById(urutan).pause();
        document.getElementById(urutan).currentTime=0;
        document.getElementById(urutan).play();
        }, totalwaktu);
        totalwaktu=totalwaktu+1000;
        });
        }else{
        setTimeout(function() {
        document.getElementById(list_audio_urutan).pause();
        document.getElementById(list_audio_urutan).currentTime=0;
        document.getElementById(list_audio_urutan).play();
        }, totalwaktu);
        totalwaktu=totalwaktu+1000;
        }
        
        //konter
        setTimeout(function() {
        document.getElementById(list_audio_konter).pause();
        document.getElementById(list_audio_konter).currentTime=0;
        document.getElementById(list_audio_konter).play();
        }, totalwaktu);
        totalwaktu=totalwaktu+1000;


        list_audio_number.forEach(number => {
        setTimeout(function() {
        document.getElementById(number).pause();
        document.getElementById(number).currentTime=0;
        document.getElementById(number).play();
        }, totalwaktu);
        totalwaktu=totalwaktu+1000;
        });

        //outro
        setTimeout(function() {
                document.getElementById(list_audio_outro).pause();
                document.getElementById(list_audio_outro).currentTime=0;
                document.getElementById(list_audio_outro).play();
                }, totalwaktu);
                totalwaktu=totalwaktu+1000;

        setTimeout(() => {
            formAudio.submit();
        }, totalwaktu);

        }
</script>
@endsection