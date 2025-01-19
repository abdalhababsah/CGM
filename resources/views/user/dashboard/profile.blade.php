@extends('dashboard-layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">@lang('profile.profile_information')</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="first_name" class="form-label">@lang('profile.first_name')</label>
                            <input type="text" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name', $user->first_name) }}" 
                                   required>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">@lang('profile.last_name')</label>
                            <input type="text" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name', $user->last_name) }}" 
                                   required>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">@lang('profile.email_address')</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if (!$user->hasVerifiedEmail())
                                <div class="text-warning mt-1">
                                    <small>@lang('profile.email_not_verified')</small>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                @lang('profile.update_profile')
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="text-danger mb-0">@lang('profile.delete_account')</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('@lang('profile.confirm_delete')');">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="password" class="form-label">@lang('profile.password')</label>
                            <input type="password" 
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password', 'userDeletion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger">
                            @lang('profile.delete_account_button')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection