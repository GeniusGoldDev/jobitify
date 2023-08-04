<main class="tk-main-bg">
    @php
        
        $trans_detail           = !empty( $invoice->TransactionDetail ) ? $invoice->TransactionDetail : null;
        $seller_payout = $billingDetail = null;

        if( in_array($invoice->payment_type, ['gig','project'])) {
            $seller_payout          = !empty( $invoice->sellerPayout ) ? $invoice->sellerPayout : null;
            $billingDetail          = !empty( $invoice->sellerPayout->billingDetail ) ? $invoice->sellerPayout->billingDetail : null;
        }
        
        $sellerInfo             = array(
            'full_name'         => '',
            'billing_company'   => '',
            'billing_email'     => '',
            'billing_address'   => '',
            'state_name'        => '',
        );

        if( !empty($billingDetail) ){

            $sellerInfo = array(
                'full_name'         => $billingDetail->full_name,
                'billing_company'   => $billingDetail->billing_company,
                'billing_email'     => $billingDetail->billing_email,
                'billing_address'   => $billingDetail->billing_address,
                'state_name'        => !empty($billingDetail->state) ? $billingDetail->state->name : '',
            );
        }

        $invoice_type       = !empty( $trans_detail->InvoiceType ) ? $trans_detail->InvoiceType : null;
        $transaction_type   = $trans_detail->transaction_type;
        $status             = getTag($invoice->status);
        $invoice_title      = $rete_per_hour = $total_hours = '';
        
        if( $transaction_type == 0 ||  $transaction_type == 1 ){
            $invoice_title  = $invoice_type->invoice_title;
        }elseif($transaction_type == 2){
            $invoice_title  = $invoice_type->project->invoice_title;
        }elseif( $transaction_type == 3 ){
            $invoice_title  = $invoice_type->invoice_title;
            $rete_per_hour  = $invoice_type->proposal->proposal_amount;
            $total_hours    = $invoice_type->total_time;
        }elseif( $transaction_type == 4 ){
            $invoice_title  = $invoice_type->gig->invoice_title;
        }

        $sr = 1;
        
    @endphp
    <section class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tk-invoicehead">
                        <a href="javascript:void(0);" class="tk-download-pdf tk-btn-solid-lg" wire:click.prevent="exportPDFInvoice" >{{__('project.download_pdf')}} <i class="icon-download"></i></a>
                    </div>
                    <div class="tk-invoicedetal">
                        <div class="tk-printable">
                            <div class="tk-invoicebill">
                                <figure>
                                @if( !empty($site_dark_logo) )
                                    <img src="{{asset('storage/'.$site_dark_logo)}}" alt="{{ __('general.logo') }}" />
                                @else
                                    <img src="{{asset('demo-content/logo.png')}}" alt="{{ __('general.logo') }}" />
                                @endif
                                </figure>
                                <div class="tk-billno">
                                    <h3>{{__('general.invoice')}}</h3>
                                    <span># {{$invoice->id}}</span>
                                </div>
                            </div>
                            <div class="tk-tasksinfos">
                                <div class="tk-invoicetasks">
                                    <h5>{{__('project.inv_project_title')}}</h5>
                                    @if( $transaction_type == 0 || $transaction_type == 4 )
                                        <h3>{{ $invoice_title }}</h3>
                                    @else
                                        <h3>{{ $invoice->sellerPayout->project->project_title }}</h3>
                                    @endif 
                                </div>
                                <div class="tk-tasksdates">
                                    <div class="tk-tags"><span class="tk-tag-ongoing {{ $status['class'] }}">{{ $status['text'] }}</span></div>
                                    <span> <em>{{__('project.inv_issue_date')}}</em> {{ date( $date_format, strtotime($invoice->created_at) )}}</span>
                                </div>
                            </div>
                            <div class="tk-invoicefromto">
                                <div class="tk-fromreceiver">
                                    <h5>{{__('project.inv_from')}}</h5>
                                    <span>
                                        {{$trans_detail->full_name}}<br>
                                        {{$trans_detail->payer_company}}<br>
                                        {{$trans_detail->payer_email}}<br>
                                        {{$trans_detail->payer_address}}<br>
                                        {{$trans_detail->payer_state}}
                                    </span>
                                </div>
                                @if( $transaction_type != 0 )
                                    <div class="tk-fromreceiver">
                                        <h5>{{__('project.inv_to')}}</h5>
                                        <span>
                                            {{$sellerInfo['full_name']}}<br>
                                            {{$sellerInfo['billing_company']}}<br>
                                            {{$sellerInfo['billing_email']}}<br>
                                            {{$sellerInfo['billing_address']}}<br>
                                            {{$sellerInfo['state_name']}}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <table class="tk-table tk-invoice-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-right"> {{__('project.inv_title')}} </th>
                                        @if( $transaction_type == 3  )
                                            <th>{{ __('project.inv_rate_per_hr') }}</th>
                                            <th>{{ __('project.inv_hr') }}</th>
                                        @endif
                                        <th class="text-right">{{ __('project.inv_amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="#"> {{ $sr++; }}</td>
                                        <td class="text-right" data-label="{{__('project.inv_title')}}">{{$invoice_title}} </td>
                                        @if ($transaction_type == 3 )
                                            <td class="text-right" data-label="{{__('project.inv_rate_per_hr')}}">{{ !empty( $rete_per_hour )  ?getPriceFormat($currency_symbol, $rete_per_hour) : ''}}</td>
                                            <td class="text-right" data-label="{{__('project.inv_hr')}}">{{ $total_hours }}</td>
                                        @endif
                                        <td class="text-right" data-label="{{__('project.inv_amount')}}">{{ getPriceFormat($currency_symbol,$trans_detail->amount + $trans_detail->used_wallet_amt) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="tk-subtotal">
                                <ul class="tk-subtotalbill">
                                    <li>{{__('project.inv_subtotal')}}<h6>{{ getPriceFormat($currency_symbol, $trans_detail->amount + $trans_detail->used_wallet_amt)}}</h6></li>
                                    @if( !empty($seller_payout) && $userRole == 'seller' && $seller_payout->admin_commission > 0 )
                                        <li>{{ __('transaction.admin_fees') }}:<h6> - {{ getPriceFormat($currency_symbol, $seller_payout->admin_commission) }}</h6></li>
                                    @endif
                                </ul>
                                <div class="tk-sumtotal">{{__('project.inv_tatal')}}<h6>{{getPriceFormat($currency_symbol, (($trans_detail->amount+ $trans_detail->used_wallet_amt) - (!empty($seller_payout) && $userRole == 'seller' ? $seller_payout->admin_commission : 0)) )}}</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>