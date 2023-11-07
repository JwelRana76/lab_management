<x-admin title="Pathology Result Heading">
    <x-page-header head="Pathology Result Heading" />
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#add_result_heading" data-toggle="modal" >
        <i class="fas fa-fw fa-plus"></i> Add Result Heading
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/result-heading" id="pathologyResultHeading" :columns="$columns" />
    </div>


  <x-modal id="add_result_heading">
    <form action="{{ route('pathology.result_heading.store') }}" method="post">
      @csrf
      <x-input id="name" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>
  <x-modal id="edit_result_heading">
    <form action="{{ route('pathology.result_heading.update') }}" method="post">
      @csrf
      <x-input id="result_heading_id" type="hidden" required />
      <x-input id="name" required />
      <button class="btn btn-primary" type="submit">Update</button>
    </form>
  </x-modal>

  @push('js')
      <script>
        function editUnit(Id){
        $.get('/pathology/result-heading/edit/'+Id,
        function(data){
          $('#edit_result_heading #result_heading_id').val(data.id);
          $('#edit_result_heading #name').val(data.name);
        })
      }
      </script>
  @endpush

</x-admin>