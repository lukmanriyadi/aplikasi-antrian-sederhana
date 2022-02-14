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
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add New Service</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/officer/service') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="mb-3">
                            <label for="service" class="form-label">Services</label>
                            <select id="service" class="form-select" name="service_id">

                                @foreach ($servicesNotHandled as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">Select Counter</div>
                <div class="card-body">
                    <h3>Your Counter Now :
                        {{ $counterHandled->name ?? 'Kosong' }}
                    </h3>
                    <form method="POST" action="{{ url('/officer/counter') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from" value="officer">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="mb-3">
                            <label for="counter" class="form-label">Counter</label>
                            <select id="counter" class="form-select" name="counter_id">
                                @foreach ($countersNotHandled as $counter)
                                <option value="{{ $counter->id }}">{{ $counter->number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List your service handled</div>

                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service Name</th>
                                <th scope="col">Code</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicesHandled as $service)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $service->service->name }}</td>
                                <td>{{ $service->service->code }}</td>
                                <td>
                                    <form action="{{ url('/officer/service/'.$service->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger">Delete</button>
                                    </form>
                                </td>
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