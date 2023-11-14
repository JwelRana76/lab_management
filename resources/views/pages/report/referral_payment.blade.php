<x-admin title="Referral Payment Report">
    <x-page-header head="Referral Payment Report" />
    <x-card>
      <x-form action="{{ route('report.referral.payment') }}" method="get">
        <div class="row m-auto">
          <div class="col-md-3">
            <x-inline-input id="start_date" type="date" value="{{ request()->start_date ?? date('Y-m-d') }}" />
          </div>
          <div class="col-md-3">
            <x-inline-input id="end_date"  type="date" value="{{ request()->end_date ?? date('Y-m-d') }}" />
          </div>
          <div class="col-md-4">
            <x-inline-select id="referral_name" class="" name="referral_id" :options="$referrals" />
          </div>
          <div>
            <button class="btn btn-sm btn-primary mb-3">Search</button>
            @if(request()->start_date)
            <a href="{{ route('report.referral.payment') }}" class="btn btn-sm btn-danger mb-3">Clear Finter</a>
            @endif
          </div>
        </div>
      </x-form>
    </x-card>
    <div class="row">
      <x-data-table dataUrl="/report/referral/payment" id="referralPaymentReport" :columns="$columns" />
    </div>
</x-admin>