<x-admin title="Report Checker">
  {{-- <x-page-header head="Report Checker" /> --}}
  <div class="row">
    <div class="col-md-6">
      <x-card header="Report Checker">
        <x-form method="post" action="{{ route('report_set.checker.update',$checker->id) }}">
            <x-input id="name" value="{{ $checker->name }}" />
            <x-input id="degree" value="{{ $checker->degree }}" />
            <x-input id="designation" value="{{ $checker->designation }}" />
            <x-input id="institute" value="{{ $checker->institute }}" />
            <x-input id="address" value="{{ $checker->address }}" />
            <x-button value="Save" />
        </x-form>
      </x-card>
    </div>
  </div>
</x-admin>