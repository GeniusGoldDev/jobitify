@role('seller')
    <main class="tb-main overflow-hidden tk-main-bg"> 
  @endrole  
    <section class="tb-main-section @if(!empty($className) ) tk-sectioninvoice @endif">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tb-invoiceslist {{$className}}">
                        <div class="tb-dhb-mainheading">
                            <h2>{{ __('transaction.invoices_bills') }}</h2>
                        </div>
                        @if(!$invoices->isEmpty())
                            <table class="table tb-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('transaction.invoice_no') }}</th>
                                        <th> {{ __('transaction.payment_type') }}</th>
                                        <th>{{ __('transaction.invoice_date') }}</th>
                                        <th>{{ __('transaction.invoice_amount') }}</th>
                                        <th>{{ __('general.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $single)
                                        <tr>
                                            <td data-label="{{ __('transaction.invoice_no') }}">{{ $single->id }}</td>
                                            <td data-label="{{ __('transaction.payment_type') }}">{{ ucfirst($single->payment_type) }}</td>
                                            <td data-label="{{ __('transaction.invoice_date') }}">{{ date( $date_format, strtotime( $single->created_at ))}}</td>
                                            <td data-label="{{ __('transaction.invoice_amount') }}"><span>{{ getPriceFormat($currency_symbol, ($single->TransactionDetail->amount+ $single->TransactionDetail->used_wallet_amt))}}  </span></td>
                                            <td data-label="{{ __('general.action') }}"><a href="{{route('invoice-detail', ['id' => $single->id]) }}" class="tb-viewdetails"><span class="icon-eye"></span> {{ __('general.view') }}</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $invoices->links('pagination.custom') }}
                        @else
                            <div class="tk-submitreview">
                                <figure>
                                    <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                                </figure>
                                <h4>{{ __('general.no_record') }}</h4>
                            </div>    
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </section>  
@role('seller')
    </main>
@endrole 
