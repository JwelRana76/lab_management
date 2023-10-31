<x-admin title="Doctor">
    <x-page-header head="Doctor" />
    <a href="{{ route('doctor.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Doctor
    </a>
    <div class="row">
      <x-data-table dataUrl="/doctor" id="doctors" :columns="$columns" />
    </div>

</x-admin>