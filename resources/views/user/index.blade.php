@extends('layouts.admin')
@php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    {{__('Manage User')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('User')}}</li>
@endsection
@section('action-btn')
    @can('create user')
        <div class="float-end">
            <a href="#" data-size="lg" data-url="{{ route('users.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endcan
@endsection
@section('content')
    @php
        $canEditUser = Gate::check('edit user');
        $canDeleteUser = Gate::check('delete user');
    @endphp
    <div class="row">
        <div class="col-xxl-12">
            <div class="row">
                @foreach($users as $user)
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-header border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <div class="badge bg-primary p-2 px-3 rounded">
                                            {{ ucfirst($user->type) }}
                                        </div>
                                    </h6>
                                </div>


                                @if($canEditUser || $canDeleteUser)
                                    <div class="card-header-right">
                                        <div class="btn-group card-option">
                                            @if($user->is_active==1)
                                                <button type="button" class="btn dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-end">

                                                    @if($canEditUser)
                                                        <a href="#!" data-size="lg" data-url="{{ route('users.edit',$user->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}">
                                                            <i class="ti ti-pencil"></i>
                                                            <span>{{__('Edit')}}</span>
                                                        </a>
                                                    @endif

                                                    @if($canDeleteUser)
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user['id']],'id'=>'delete-form-'.$user['id']]) !!}
                                                        <a href="#!"  class="dropdown-item bs-pass-para">
                                                            <i class="ti ti-archive"></i>
                                                            <span> @if($user->delete_status!=0){{__('Delete')}} @else {{__('Restore')}}@endif</span>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    @endif

                                                    <a href="#!" data-url="{{route('users.reset',\Crypt::encrypt($user->id))}}" data-ajax-popup="true" data-size="md" class="dropdown-item" data-bs-original-title="{{__('Reset Password')}}">
                                                        <i class="ti ti-adjustments"></i>
                                                        <span>  {{__('Reset Password')}}</span>
                                                    </a>
                                                </div>
                                            @else
                                                <a href="#" class="action-item"><i class="ti ti-lock"></i></a>
                                            @endif

                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body full-card">
                                <div class="img-fluid rounded-circle card-avatar">
                                    <img src="{{(!empty($user->avatar))? asset(Storage::url("uploads/avatar/".$user->avatar)): asset(Storage::url("uploads/avatar/avatar.png"))}}" class="img-user wid-80 round-img rounded-circle">
                                </div>
                                <h4 class=" mt-3 text-primary">{{ $user->name }}</h4>
                                @if($user->delete_status==0)
                                    <h5 class="office-time mb-0">{{__('Soft Deleted')}}</h5>
                                @endif
                                <small class="text-primary">{{ $user->email }}</small>
                                <p></p>
                                <div class="text-center" data-bs-toggle="tooltip" title="{{__('Last Login')}}">
                                    {{ (!empty($user->last_login_at)) ? $user->last_login_at : '' }}
                                </div>
                                @if(\Auth::user()->type == 'super admin')
                                    @php($featureSettings = $featureSettingsByCompany[$user->id] ?? ['feature_account' => 'on', 'feature_hrm' => 'on', 'feature_crm' => 'on', 'feature_project' => 'on', 'feature_pos' => 'on'])
                                    <div class="mt-4">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-6 text-center">
                                                <span class="d-block font-bold mb-0">{{ !empty($user->currentPlan) ? $user->currentPlan->name : '' }}</span>
                                            </div>
                                            <div class="col-6 text-center Id ">
                                                <a href="#" data-url="{{ route('plan.upgrade',$user->id) }}" data-size="lg" data-ajax-popup="true" class="btn btn-outline-primary"
                                                   data-title="{{__('Upgrade Plan')}}">{{__('Upgrade Plan')}}</a>
                                            </div>
                                            <div class="col-12">
                                                <hr class="my-3">
                                            </div>
                                            <div class="col-12 text-center pb-2">
                                                <span class="text-dark text-xs">{{__('Plan Expired : ') }} {{!empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date): __('Unlimited')}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="card mb-0">
                                                <div class="card-body p-3 text-start">
                                                    <h6 class="mb-2">{{ __('Feature Access') }}</h6>
                                                    <form method="POST" action="{{ route('user.feature.settings', $user->id) }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="checkbox" class="form-check-input input-primary" id="feature_account_{{ $user->id }}" name="feature_account" {{ ($featureSettings['feature_account'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="feature_account_{{ $user->id }}">{{ __('Accounting') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="checkbox" class="form-check-input input-primary" id="feature_hrm_{{ $user->id }}" name="feature_hrm" {{ ($featureSettings['feature_hrm'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="feature_hrm_{{ $user->id }}">{{ __('HRM') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="checkbox" class="form-check-input input-primary" id="feature_crm_{{ $user->id }}" name="feature_crm" {{ ($featureSettings['feature_crm'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="feature_crm_{{ $user->id }}">{{ __('CRM') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="checkbox" class="form-check-input input-primary" id="feature_project_{{ $user->id }}" name="feature_project" {{ ($featureSettings['feature_project'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="feature_project_{{ $user->id }}">{{ __('Project') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="checkbox" class="form-check-input input-primary" id="feature_pos_{{ $user->id }}" name="feature_pos" {{ ($featureSettings['feature_pos'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="feature_pos_{{ $user->id }}">{{ __('POS') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-3 text-end">
                                                                <button type="submit" class="btn btn-sm btn-primary">{{ __('Save Features') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-12">
                                            <div class="card mb-0">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip" title="{{__('Users')}}"><i class="ti ti-users card-icon-text-space"></i>{{ $companyUserCounts[$user->id] ?? 0 }}</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip" title="{{__('Customers')}}"><i class="ti ti-users card-icon-text-space"></i>{{ $companyCustomerCounts[$user->id] ?? 0 }}</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip" title="{{__('Vendors')}}"><i class="ti ti-users card-icon-text-space"></i>{{ $companyVenderCounts[$user->id] ?? 0 }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
