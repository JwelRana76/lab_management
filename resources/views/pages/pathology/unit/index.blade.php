<x-admin title="Pathology Unit">
    <x-page-header head="Pathology Unit" />
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#add_unit" data-toggle="modal" >
        <i class="fas fa-fw fa-plus"></i> Add Unit
    </a>
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#import_unit" data-toggle="modal" >
        <i class="fas fa-fw fa-upload"></i> Import Result Name
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/unit" id="pathologyUnit" :columns="$columns" />
    </div>

  <x-modal id="import_unit">
    <x-form action="{{ route('pathology.unit.import') }}" method="post">
      @csrf
      <x-input id="result_file" type="file" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </x-form>
  </x-modal>
  <x-modal id="add_unit">
    <form action="{{ route('pathology.unit.store') }}" method="post">
      @csrf
      <x-input id="name" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>
  <x-modal id="edit_unit">
    <form action="{{ route('pathology.unit.update') }}" method="post">
      @csrf
      <x-input id="unit_id" type="hidden" required />
      <x-input id="name" required />
      <button class="btn btn-primary" type="submit">Update</button>
    </form>
  </x-modal>

  @push('js')
      <script>
        function editUnit(Id){
        $.get('/pathology/unit/edit/'+Id,
        function(data){
          $('#edit_unit #unit_id').val(data.id);
          $('#edit_unit #name').val(data.name);
        })
      }
      </script>
  @endpush

</x-admin>