<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_users') .' ('. $users->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new" data-bs-toggle="modal" data-bs-target="#tb-add-user">{{__('general.add_new_user')}} <i class="icon-plus"></i></a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_user" class="form-control tk-selectprice">
                                            <option value =""> {{ __('general.all_users') }} </option>
                                            <option value ="verified"> {{ __('general.verified') }} </option>
                                            <option value ="non-verified"> {{ __('general.non-verified') }} </option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" class="form-control">
                                            @foreach($per_page_opt as $opt ){
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_user"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$users->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('general.email' )}}</th>
                                <th>{{ __('general.created_date' )}}</th>
                                <th>{{ __('general.hourly_rate' )}}</th>
                                <th>{{ __('general.verification' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $single)
                                @php

                                $tag = getTag( $single->status );
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __('general.email' )}}"><span>{{ $single->email }}</span></td>
                                    <td data-label="{{ __('general.created_date' )}}"><span>{{ date($date_format, strtotime( $single->created_at )) }}</span></td>
                                    <td data-label="{{ __('general.hourly_rate' )}}"><span>{{ getPriceFormat($currency_symbol, (empty($single->userAccountSetting->hourly_rate) ? 0 : $single->userAccountSetting->hourly_rate)) .'/hr' }}</span></td>
                                    <td data-label="{{ __('general.verification' )}}">
                                        <a href="javascript:;" class="tb-email-verifiedbtn"  {{ empty($single->email_verified_at) ? "onClick=confirmation('".$single->id."','approve') disabled=true" : "onClick=confirmation('".$single->id."','reject')"}}><i class="icon-mail"></i>{{ strtoupper(__('general.verified')) }}</a>
                                        @if(!empty($single->userIdentity))<a href="javascript:void(0)" wire:click.prevent="identityInfo({{ $single->id }})" class="tb-verifiedbtn" {{ $single->userAccountSetting->verification != 'approved'  ? 'disabled=true' : ''}}><i class="icon-award"></i>{{strtoupper( __('general.verified')) }}</a>@endif
                                    </td>
                                    <td data-label="{{__('general.status')}}">

                                        <em class="tk-project-tag tk-{{ $single->status == 'activated' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}" class="tb-action-profile">
                                        
                                        <ul class="tb-action-status">
                                            <li> 
                                                <a href="javascript:void(0);" onClick="deleteUser({{ $single->id }})" class="tb-delete" ><i class="icon-trash-2"></i></a>
                                            </li> 
                                            @if( $single->profile->count() > 1 )
                                                @foreach($single->profile as $profile)
                                                    @if($profile->role->name == 'seller')
                                                    <li><a href="{{ route('seller-profile', ['slug' => $profile->slug]) }}" target="_blank">{{ ucfirst(__('general.view_profile', ['role' => $profile->role->name])) }}<i class="icon-external-link"></i></a></li>
                                                    @endif
                                                @endforeach
                                            @else
                                                @if($single->profile[0]->role->name == 'seller')
                                                    <li><a href="{{ route('seller-profile', ['slug' => $single->profile[0]->slug]) }}" target="_blank">{{ ucfirst(__('general.view_profile', ['role' => $single->profile[0]->role->name])) }}<i class="icon-external-link"></i></a></li>
                                                @endif
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                        {{ $users->links('pagination.custom') }}  
                    @else
                        @include('admin.no-record')
                    @endif  
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="identity-info-modal"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h4> {{ __('general.user_identity_info') }} </h4>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        @if( !empty($user_identity_info) )
                            @if(!$reject_user_identity)
                                <ul class="tb-userinfo">
                                    <li>
                                        <span>{{ __('general.name') }}:</span>
                                        <h6>{{ $user_identity_info['name'] }}</h6>
                                    </li>
                                    <li>
                                        <span>{{ __('general.contact_no') }}:</span>
                                        <h6>{{ $user_identity_info['contact_no'] }}</h6>
                                    </li>
                                    <li>
                                        <span>{{ __('general.identity_no') }}:</span>
                                        <h6>{{ $user_identity_info['identity_no'] }}</h6>
                                    </li>
                                    <li>
                                        <span>{{ __('general.address') }}:</span>
                                        <h6>{!! $user_identity_info['address'] !!}</h6>
                                    </li>
                                    @if( !empty($user_identity_info['attachments']) )
                                        <li>
                                            <span>{{ __('general.identity_attachments') }}:</span>
                                            <h6><a href="javascript:;" wire:click.prevent="downloadAttachments({{ $user_identity_info['id'] }})">{{ __('general.download') }}</a></h6>
                                        </li>
                                    @endif
                                </ul>
                        
                                <div class="tb-userverfication-btns">
                                    @if($user_identity_info['verification'] != 'approved')
                                        <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="verifyUserIdentity({{ $user_identity_info['id'] }}, 'approve')" class="tb-btn">
                                            <span wire:loading wire:target="verifyUserIdentity"> {{__('general.waiting')}} </span>
                                            <span wire:loading.remove wire:target="verifyUserIdentity">{{ __('general.approve') }} </span>
                                        </a>
                                    @endif
                                    <a href="javascript:;" wire:click.prevent="verifyUserIdentity({{ $user_identity_info['id'] }}, 'reject')" class="tb-rejectbtn">{{ __('general.reject') }}</a>
                                </div>                     
                            @else
                                <textarea wire:model.defer="identity_reject_reason" placeholder="{{ __('general.decline_reason') }}" class="form-control  @error('identity_reject_reason') tk-invalid @enderror"></textarea>
                                @error('identity_reject_reason') 
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                                <div class="tb-userverfication-btns">
                                    <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="verifyUserIdentity({{ $user_identity_info['id'] }}, 'reject')" class="tb-btn">
                                        <span wire:loading wire:target="verifyUserIdentity"> {{__('general.waiting')}} </span>
                                        <span wire:loading.remove wire:target="verifyUserIdentity">{{ __('general.reject') }} </span>
                                    </a>
                                    <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="updateUserIdentity" class="tb-rejectbtn">
                                        <span wire:loading wire:target="updateUserIdentity"> {{__('general.waiting')}} </span>
                                        <span wire:loading.remove wire:target="updateUserIdentity">{{ __('general.cancel') }} </span>
                                    </a>
                                </div> 
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-user" aria-labelledby="tb_user_info_label" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_user_info_label">{{__('general.user_information')}}</h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" id="add_user_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.first_name')}}</label>
                                        <input type="text" class="form-control @error('first_name') tk-invalid @enderror" wire:model.defer="first_name" placeholder="{{__('general.name_placeholder')}}">
                                        @error('first_name')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.last_name')}}</label>
                                        <input type="text" class="form-control @error('last_name') tk-invalid @enderror" wire:model.defer="last_name" placeholder="{{__('general.lastname_placeholder')}}">
                                        @error('last_name')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.email')}}</label>
                                        <input type="text" class="form-control @error('email') tk-invalid @enderror" wire:model.defer="email" placeholder="{{__('general.email_placeholder')}}">
                                        @error('email')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.user_role')}}</label>
                                        <div class="tk-error @error('user_role') tk-invalid @enderror">
                                            <div class="tb-select" wire:ignore>
                                                <select id="select_role" class="form-control" data-placeholder="{{__('general.user_role')}}" data-placeholderinput="{{__('general.search')}}">
                                                <option label="{{__('general.user_role')}}"></option>
                                                    <option value="buyer">{{__('general.buyer_option')}}</option>
                                                    <option value="seller">{{__('general.seller_option')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('user_role')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.password')}}</label>
                                        <input type="password" wire:model.defer="password" class="form-control @error('password') tk-invalid @enderror"  placeholder="{{__('general.password_placeholder')}}">
                                        @error('password')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.confirm_password')}}</label>
                                        <input type="password" wire:model.defer="confirm_password" class="form-control @error('confirm_password') tk-invalid @enderror" placeholder="{{__('general.password_placeholder')}}">
                                        @error('confirm_password')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group tb-formbtn">
                                        <a href="javascript:void(0)" wire:click.prevent="saveUser" class="tb-btn">{{__('general.save_user')}}</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        setTimeout(function() {
            $('#filter_user').select2({ 
                allowClear: true, 
                minimumResultsForSearch: Infinity
            });

            $('#select_role').select2({
                dropdownParent: $("#tb-add-user"),
                allowClear: true, 
                minimumResultsForSearch: Infinity,
            });

            $('#select_role').on('change', function (e) {
                let user_role = $('#select_role').select2("val");
                @this.set('user_role', user_role, true);
            });

            $('#filter_user').on('change', function (e) {
                let filter_user = $('#filter_user').select2("val");
                @this.set('filter_user', filter_user);
            });
        }, 50);

        $(document).on('click','#add_user_click', function (e) {
            document.getElementById("add_user_form").reset();
        });

        window.addEventListener('add-new-user-modal', event => {
            if(event.detail.modal == 'show'){
                $('#tb-add-user').modal().show()
            } else {
                $('#tb-add-user').modal('hide')
            }
        });

        window.addEventListener('indentity-info-modal', event => {
            $('#identity-info-modal').modal(event.detail.modal);
        });

    });

    function confirmation(id, status ){
        if(status == 'approve'){
            let title           = '{{ __("general.approve_email_acc") }}';
            let content         = '{{ __("general.approve_email_acc_desc") }}';
            let action          = 'emailVerifyConfirm';
            let status          = 'approve';
            let type_color      = 'green';
            let btn_class      = 'success';
            ConfirmationBox({title, content, action, id, status, type_color, btn_class})
        }else if(status == 'reject'){
            let title           = '{{ __("general.reject_email_acc") }}';
            let content         = '{{ __("general.reject_email_acc_desc") }}';
            let action          = 'emailVerifyConfirm';
            let status          = 'reject';
            let type_color      = 'red';
            let btn_class      = 'red';
            ConfirmationBox({title, content, action, id, status, type_color, btn_class})
        }
    }

    function deleteUser( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.delete_user") }}';
        let action          = 'deleteUser';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }

</script>
@endpush
