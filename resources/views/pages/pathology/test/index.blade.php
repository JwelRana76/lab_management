<x-admin title="Pathology Test">
    <x-page-header head="Pathology Test" />
    <a href="{{ route('test.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Test
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/test" id="pathologyTest" :columns="$columns" />
    </div>

</x-admin>