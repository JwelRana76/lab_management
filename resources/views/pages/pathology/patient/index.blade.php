<x-admin title="Pathology Patient">
    <x-page-header head="Pathology Patient" />
    <a href="{{ route('doctor.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Doctor
    </a>
    <div class="row">
      <x-data-table dataUrl="/doctor" id="doctors" :columns="$columns" />
    </div>

</x-admin>