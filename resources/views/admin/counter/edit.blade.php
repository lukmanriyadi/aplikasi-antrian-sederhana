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
                        Edit Counter
                    </h3>
                    <a href="{{ url('/admin/counter/') }}" class="btn btn-sm btn-primary">Back to List Counter</a>
                    <form method="post" action="{{ url('/admin/counter/'.$counter->id) }}" class="mt-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from" value="admin">
                        <div class="mb-3">
                            <label for="number" class="form-label">Counter Number</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" value="{{ old('number', $counter->number) }}">
                            @error('number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="status" class="form-label">Status Service</label>
                            <select id="status" class="form-select" name="status">
                                <option @if (old('status', $counter->status)==1) selected @endif value="1">Active
                                </option>
                                <option @if (old('status', $counter->status)==0) selected @endif value="0">Non Active
                                </option>
                            </select>
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection