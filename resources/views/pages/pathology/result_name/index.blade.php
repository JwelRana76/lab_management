<x-admin title="Pathology Result Name">
    <x-page-header head="Pathology Result Name" />
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#add_unit" data-toggle="modal" >
        <i class="fas fa-fw fa-plus"></i> Add Unit
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/result-name" id="pathologyResultName" :columns="$columns" />
    </div>


  <x-modal id="add_unit">
    <form action="{{ route('pathology.result_name.store') }}" method="post">
      @csrf
      <x-input id="name" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>
  <x-modal id="edit_resutl_name">
    <form action="{{ route('pathology.result_name.update') }}" method="post">
      @csrf
      <x-input id="result_name_id" type="hidden" required />
      <x-input id="name" required />
      <button class="btn btn-primary" type="submit">Update</button>
    </form>
  </x-modal>

  @push('js')
      <script>
        function editUnit(Id){
        $.get('/pathology/result-name/edit/'+Id,
        function(data){
          $('#edit_resutl_name #result_name_id').val(data.id);
          $('#edit_resutl_name #name').val(data.name);
        })
      }
      </script>
  @endpush

</x-admin>