@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Invite Merchants</div>
                <div class="panel-body">

                    @include('misc._messages')

                    {{ Form::open(['route' => 'inviteMerchants', 'class' => 'form-horizontal']) }}

                        <div class="form-group{{ $errors->has('emails') ? ' has-error' : '' }}">
                            <label for="emails" class="col-md-4 control-label">Emails</label>

                            <div class="col-md-6">
                                <textarea id="emails" class="form-control" name="emails" required autofocus>{{ old('emails') ?: $invalidEmails }}</textarea>

                                <span class="help-block">
                                    @if ($errors->has('emails'))
                                        <strong>
                                            {{ $errors->first('emails') }}
                                            <br>
                                            Enter one email per line, or separate with comma.
                                        </strong>
                                    @else
                                        Enter one email per line, or separate with comma.
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add emails
                                </button>
                            </div>
                        </div>

                    {{ Form::close() }}

                    <invite-merchants-table api-url="{{ route('getMerchantInvitations') }}"></invite-merchants-table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
