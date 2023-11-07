<x-admin title="Pathology Test Setup">
    <x-page-header head="Pathology Test Setup" />
    <a href="#" class="btn btn-sm btn-primary m-2" >
        <i class="fas fa-fw fa-plus"></i> Add Setup
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/test/setup" id="pathologyTestSetup" :columns="$columns" />
    </div>
</x-admin>