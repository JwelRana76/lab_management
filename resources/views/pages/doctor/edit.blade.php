<x-admin title="Doctor">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Doctor Create" links="{{ route('doctor.index') }}" title="Doctor List">
        <x-form action="{{ route('doctor.update',$doctor->id) }}" method="post">
            <div class="row">
                <x-input id="name" value="{{ $doctor->name }}" class="col-md-4" required />
                <x-input id="contact" value="{{ $doctor->contact }}" class="col-md-4" required />
                <x-input id="email" value="{{ $doctor->email }}" class="col-md-4" />
                <x-input id="designation" value="{{ $doctor->designation }}" class="col-md-4" />
                <x-input id="institute" value="{{ $doctor->institute }}" class="col-md-4" />
                <div class="col-md-4">
                    <x-select id="gender" name="gender_id" selectedId="{{ $doctor->gender_id }}" :options="$gender" class="col-md-4" required />
                </div>
                <div class="col-md-4">
                    <x-select id="religion" name="religion_id" selectedId="{{ $doctor->religion_id }}" :options="$religion" class="col-md-4" />
                </div>
                <div class="col-md-4">
                    <x-select id="blood_group" name="blood_group_id" selectedId="{{ $doctor->blood_group_id }}" :options="$blood_group" class="col-md-4" />
                </div>
                <div class="col-md-4">
                <x-input type="file" id="photo" />
                @if ($doctor->photo)
                <div>
                    <img src="/upload/doctor/{{ $doctor->photo }}" alt="photo" width="50px">
                </div>
                @endif
                </div>
            </div>
            <x-button value="Update" />
        </x-form>
    </x-card>
</x-admin>