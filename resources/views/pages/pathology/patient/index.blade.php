<x-admin title="Pathology Patient">
    <x-page-header head="Pathology Patient" />
    @if (userHasPermission('patient-store'))
    <a href="{{ route('pathology.patient.create') }}" class="btn btn-sm btn-primary my-2">
      <i class="fas fa-fw fa-plus"></i> Add Patient
    </a>
    @endif
    <div class="row">
      <x-data-table dataUrl="/patient" id="patients" :columns="$columns" />
    </div>

</x-admin>