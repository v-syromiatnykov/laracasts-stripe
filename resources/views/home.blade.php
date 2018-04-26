@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <checkout-form :plans="{{ $plans }}"></checkout-form>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">Payments</div>

                <div class="card-body">
                    <ul class="list-group">
                        @foreach(auth()->user()->payments as $payment)
                            <li class="list-group-item">
                                {{ $payment->created_at->diffForHumans() }} :
                                <strong>
                                    ${{ $payment->inDollars() }}
                                </strong></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
