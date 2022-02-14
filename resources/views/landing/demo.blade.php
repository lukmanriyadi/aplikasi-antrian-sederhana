@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Demo</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>Demo</h2>
                    <table class="table table-bordered table-striped text-center mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Counter Name</th>
                                <th scope="col">Person Responsible</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection