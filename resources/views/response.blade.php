@extends('layouts.app')
@section('container')
<div class="container" style="margin-top: 150px">
        <div class="row">
            <div class="col-sm-12">
                <div class="error-section">
                    
                    <p>
                    {{ $response }}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
