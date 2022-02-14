@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    Counter NO : {{ $counter->name }}
                    <form action="{{ url('/officer/queue') }}" method="get" class="d-inline">
                        <input type="hidden" name="new" value="1">
                        <button submit class="btn btn-sm btn-primary">Process New Queue</button>
                    </form>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="text-center">
                        @if ($active == false && (!empty($queue)))
                        <h3>Queue Unactive</h3>
                        <h5>Click Process new queue to get new queue</h5>
                        @elseif(empty($queue))
                        <h3>Queue Empty</h3>
                        @else
                        <h3>Queue Active</h3>
                        <h4>No : {{ $queue->number }}</h4>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ url('/audio') }}" class="d-inline" method="POST">
                            @csrf
                            <input type="hidden" name="queue_id" value="{{ $queue->id }}">
                            <input type="hidden" name="queue_number" value="{{ $queue->number }}">
                            <input type="hidden" name="counter_number" value="{{ $counter->number }}">
                            <input type="hidden" name="status" value="Waiting">
                            @if ($requestCall)
                            <button type="submit" class="btn btn-primary">Panggil</button>
                            @endif
                        </form>
                        {{-- <button type="button" onclick="mulai()"
                            class="btn btn-primary btn-panggil">Panggil</button> --}}
                        <button class="btn btn-primary btn-loading d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <h4>Service : {{ $queue->service->name }}</h4>
                        <h4>Status : Processed</h4>
                        <form action="{{ url('/queue/'.$queue->id) }}" style="d-inline" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">End Process Queue</button>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection