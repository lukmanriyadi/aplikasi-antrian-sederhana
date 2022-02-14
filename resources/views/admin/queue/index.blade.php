@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">List Queue</div>

                <div class="card-body">
                    <h2>List Queue</h2>

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