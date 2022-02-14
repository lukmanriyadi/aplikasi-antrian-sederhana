@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>Choose Your Service</h2>
                    <form action="{{ url('/queue') }}" method="POST" target="_blank">
                        @csrf
                        <div class="mt-3">
                            <label for="service" class="form-label">Service</label>
                            <select id="service" class="form-select" name="service_id">
                                @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">List Queue</div>

                <div class="card-body">
                    <h2>List Active Queue</h2>
                    <a href="{{ url('/') }}" class="btn btn-primary">Refresh Page</a>
                    <table class="table table-bordered table-striped text-center mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service</th>
                                <th scope="col">Code</th>
                                <th scope="col">Status</th>
                                <th scope="col">created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($queues as $queue)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $queue->service->name }}</td>
                                <td>{{ $queue->number }}</td>
                                <td>{{ $queue->status }}</td>
                                <td>{{ $queue->created_at }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection