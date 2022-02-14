@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Monitor Counter</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>List Counter</h2>
                    @if (auth()->user()->isAdmin())
                    <a href="{{ url('/admin/counter/create') }}" class="btn btn-sm btn-primary">Add new Counter</a>
                    @endif
                    <table class="table table-bordered table-striped text-center mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Counter Number</th>
                                <th scope="col">Person Responsible</th>
                                <th scope="col">Status</th>
                                @if (auth()->user()->isAdmin())
                                <th scope="col">Action</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($counters as $counter)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $counter->number }}</td>
                                @if ($counter->user)
                                <td>{{ $counter->user->name }}</td>
                                @else
                                <td>Kosong</td>
                                @endif
                                {{-- Start check status kosong --}}
                                @if ($status->isEmpty())
                                {{-- Start check status == 1 atau active --}}
                                @if ($counter->status == 1)
                                <td><span class="badge bg-primary">Active</span></td>
                                @else
                                <td><span class="badge bg-dark">Non Active</span></td>
                                @endif
                                {{-- end check status == 1 atau active --}}
                                @else
                                {{-- Start check status ada, bisa active/processing --}}
                                @php
                                $ketemu = false;
                                @endphp
                                @foreach ($status as $s)
                                @if ($s->user_id == $counter->user_id)
                                @php
                                $ketemu = true;
                                @endphp
                                <td> <span class="badge bg-success">Processing</span></td>
                                @endif
                                @endforeach
                                {{-- end check status ada, bisa active/processing --}}
                                @if (!$ketemu)
                                @if ($counter->status == 1)
                                <td><span class="badge bg-info">Active</span></td>
                                @else
                                <td> <span class="badge bg-dark">Non Active</span> </td>
                                @endif
                                @endif
                                @endif
                                {{-- End check status kosong --}}
                                @if (auth()->user()->isAdmin())
                                <td>
                                    <a href="{{ url('/admin/counter/'.$counter->id.'/edit') }}"
                                        class="btn btn-success btn-sm">Edit</a>
                                    <form action="{{ url('/admin/counter/'.$counter->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="return confirm('are you sure?')">Delete</button>
                                    </form>
                                </td>

                                @endif
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