<x-admin title="Referral">
    {{-- <x-page-header head="Referral" /> --}}
    <x-card header="Referral Create" links="{{ route('referral.index') }}" title="Referral List">
        <x-form action="{{ route('referral.store') }}" method="post">
            <div class="row">
                <x-input id="name" class="col-md-4" required />
                <x-input id="contact" class="col-md-4" required />
                <div class="col-md-4">
                    <x-select id="gender" name="gender_id" :options="$gender" class="col-md-4" required />
                </div>
                <div class="col-md-4">
                    <x-select id="religion" name="religion_id" :options="$religion" class="col-md-4" />
                </div>
            </div>
            <x-button value="Save" />
        </x-form>
    </x-card>
</x-admin>