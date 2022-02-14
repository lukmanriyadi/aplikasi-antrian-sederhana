@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h3>
                        List Service
                    </h3>
                    <a href="{{ url('/admin/service/create') }}" class="btn btn-sm btn-primary">Create New</a>
                    <table class="table table-bordered table-striped text-center mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Code</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->code }}</td>
                                <td>{{ $service->status == 1 ? 'Active': 'Non Active' }}</td>
                                <td>
                                    <a href="{{ url('/admin/service/'.$service->id.'/edit') }}"
                                        class="badge bg-info">Edit</a>

                                    <form action="{{ url('/admin/service/'.$service->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="badge bg-danger"
                                            onclick="return confirm('Are You Sure?');">Delete</button>
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