<x-admin title="Pathology Tube">
    <x-page-header head="Pathology Tube" />
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#add_tube" data-toggle="modal" >
        <i class="fas fa-fw fa-plus"></i> Add Tube
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/tube" id="pathologyTube" :columns="$columns" />
    </div>


  <x-modal id="add_tube">
    <form action="{{ route('tube.store') }}" method="post">
      @csrf
      <x-input id="name" required />
      <x-input id="code" required />
      <x-input id="rate" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>
  <x-modal id="edit_tube">
    <form action="{{ route('tube.update') }}" method="post">
      @csrf
      <x-input id="tube_id" type="hidden" required />
      <x-input id="name" required />
      <x-input id="code" required />
      <x-input id="rate" required />
      <button class="btn btn-primary" type="submit">Update</button>
    </form>
  </x-modal>

  @push('js')
      <script>
        function editTueb(Id){
        $.get('/pathology/tube/edit/'+Id,
        function(data){
          $('#edit_tube #tube_id').val(data.id);
          $('#edit_tube #name').val(data.name);
          $('#edit_tube #code').val(data.code);
          $('#edit_tube #rate').val(data.rate);
        })
      }
      </script>
  @endpush

</x-admin>