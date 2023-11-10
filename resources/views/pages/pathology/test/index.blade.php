<x-admin title="Pathology Test">
    <x-page-header head="Pathology Test" />
    <a href="{{ route('test.create') }}" class="btn btn-sm btn-primary m-2">
        <i class="fas fa-fw fa-plus"></i> Add Test
    </a>
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#create_category" data-toggle="modal" >
        <i class="fas fa-fw fa-plus"></i> Add Category
    </a>
    <a href="#" class="btn btn-sm btn-primary m-2" data-target="#category_list" data-toggle="modal" >
        <i class="fas fa-fw fa-list"></i> Category List
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/test" id="pathologyTest" :columns="$columns" />
    </div>


  <x-modal id="create_category">
    <form action="{{ route('test_category.categorystore') }}" method="post">
      @csrf
      <x-input id="name" required />
      <x-input id="code" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>
  <x-modal id="category_list">
    <table class="table table-striped">
      <tr>
        <th>SL</th>
        <th>Name</th>
        <th>Code</th>
        <th>Action</th>
      </tr>
      @foreach ($categories as $key=>$item)
          <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->code }}</td>
            <td>
              <div class="btn-group dropleft">
                <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-fw fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" onclick="categoryEdit({{ $item->id }})" data-target="#edit_category" data-toggle="modal" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
                    <a class="dropdown-item" href="{{ route('test_category.delete',$item->id) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fa fa-fw text-danger fa-trash"></i> Delete</a>
                </div>  
              </div>
            </td>
          </tr>
      @endforeach
    </table>
  </x-modal>
  <x-modal id="edit_category">
    <form action="{{ route('test_category.update') }}" method="post">
      @csrf
      <x-input id="category_id" type="hidden" required />
      <x-input id="category_name" required />
      <x-input id="category_code" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>

  @push('js')
      <script>
        function categoryEdit(Id){
        $.get('/pathology/test_category/edit/'+Id,
        function(data){
          $('#edit_category #category_id').val(data.id);
          $('#edit_category #category_name').val(data.name);
          $('#edit_category #category_code').val(data.code);
        })
      }
      </script>
  @endpush

</x-admin>