@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(auth()->user()->isOnGracePeriod())
                    <div class="card">
                        <div class="card-header">Grace Period</div>

                        <div class="card-body">
                            <p>
                                Your subscription will fully expire on
                                <strong>
                                    {{ auth()->user()->subscription_end_at->format('Y-m-d') }}
                                </strong>
                            </p>

                            <form method="POST" action="/subscriptions">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <div class="checkbox">
                                    <label for="resume">
                                        <input type="checkbox" name="resume" id="resume">
                                        Resume My Subscription
                                    </label>
                                </div>

                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                @endif

                @unless(auth()->user()->hasCanceled() || auth()->user()->isOnGracePeriod())
                    <div class="card">
                        <div class="card-header">Create a Subscription</div>

                        <div class="card-body">
                            <checkout-form :plans="{{ $plans }}"></checkout-form>
                        </div>
                    </div>
                @endunless

                <div class="card mt-5">
                    <div class="card-header">Payments</div>

                    <div class="card-body">
                        @if(auth()->user()->payments)
                            <ul class="list-group">
                                @foreach(auth()->user()->payments as $payment)
                                    <li class="list-group-item">
                                        {{ $payment->created_at->diffForHumans() }} :
                                        <strong>
                                            ${{ $payment->inDollars() }}
                                        </strong></li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center">No payments yet...</p>
                        @endif
                    </div>
                </div>

                @if(auth()->user()->hasCanceled())
                    <div class="card mt-5">
                        <div class="card-header">Cancel</div>

                        <div class="card-body">
                            <form method="POST" action="/subscriptions">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn btn-danger">Cancel My Subscription</button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
