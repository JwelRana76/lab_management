<x-admin title="Referral">
    <x-page-header head="Referral" />
    <a href="{{ route('referral.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Referral
    </a>
    <div class="row">
      <x-data-table dataUrl="/referral" id="referrals" :columns="$columns" />
    </div>

</x-admin>