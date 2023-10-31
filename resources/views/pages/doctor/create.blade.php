<x-admin title="Doctor">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Doctor Create" links="{{ route('doctor.index') }}" title="Doctor List">
        <x-form action="{{ route('doctor.store') }}" method="post">
            <div class="row">
                <x-input id="name" class="col-md-4" required />
                <x-input id="contact" class="col-md-4" required />
                <x-input id="email" class="col-md-4" />
                <x-input id="designation" class="col-md-4" />
                <x-input id="institute" class="col-md-4" />
                <div class="col-md-4">
                    <x-select id="gender" name="gender_id" :options="$gender" class="col-md-4" required />
                </div>
                <div class="col-md-4">
                    <x-select id="religion" name="religion_id" :options="$religion" class="col-md-4" />
                </div>
                <div class="col-md-4">
                    <x-select id="blood_group" name="blood_group_id" :options="$blood_group" class="col-md-4" />
                </div>
                <x-input type="file" id="photo" class="col-md-4" />
            </div>
            <x-button value="Save" />
        </x-form>
    </x-card>
</x-admin>