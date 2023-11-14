<x-admin title="Doctor Refer Report">
    <x-page-header head="Doctor Refer Report" />
    <x-card>
      <x-form action="{{ route('report.doctor') }}" method="get">
        <div class="row m-auto">
          <div class="col-md-3">
            <x-inline-input id="start_date" type="date" value="{{ request()->start_date ?? date('Y-m-d') }}" />
          </div>
          <div class="col-md-3">
            <x-inline-input id="end_date"  type="date" value="{{ request()->end_date ?? date('Y-m-d') }}" />
          </div>
          <div class="col-md-4">
            <x-inline-select id="doctor_name" class="" name="doctor_id" :options="$doctors" />
          </div>
          <div>
            <button class="btn btn-sm btn-primary mb-3">Search</button>
            @if(request()->start_date)
            <a href="{{ route('report.doctor') }}" class="btn btn-sm btn-danger mb-3">Clear Finter</a>
            @endif
          </div>
        </div>
      </x-form>
    </x-card>
    <div class="row">
      <x-data-table dataUrl="/report/doctor" id="doctorReport" :columns="$columns" />
    </div>
</x-admin>