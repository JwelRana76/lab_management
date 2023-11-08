<x-admin title="Pathology Test Setup Edit">
    {{-- <x-page-header head="Referral" /> --}}
  <x-card header="Pathology Test Setup Edit" links="{{ route('pathology.test_setup.index') }}" title="Test Setup List">
    <x-form action="{{ route('pathology.test_setup.update',$setup->id) }}" method="post">
      <div class="row">
        <div class="col-md-6">
          <x-select id="category_name" selectedId="{{ $setup->test->pathology_test_category_id }}" name="category_id" :options="$category" required />
        </div>
        <div class="col-md-6">
          <x-select id="test_name" selectedId="{{ $setup->test_id }}" name="test_id" :options="$tests" required />
        </div>
        <div class="col-md-12">
          <x-select id="result_name" name="result_id" :options="$test_result_name" />
        </div>
      </div>
      <div class="row mt-5">
        <table class="table">
          <thead>
            <tr>
              <th>Result Name</th>
              <th>Result Type</th>
              <th>Heading</th>
              <th>Unit</th>
              <th>Cal. Value</th>
              <th>Cal. Type</th>
              <th>Convart Unit</th>
              <th>Default Value</th>
              <th>Normal Value</th>
              <th>Action</th>
            </tr>
          </thead>
          @php
              $setup_result = App\Models\PathologyTestSetupResult::where('pathology_test_setup_id',$setup->id)->get();
          @endphp
          <tbody id="test_setup_table_body">
            @foreach ($setup_result as $item)
            <tr  data-test-id="{{ $item->result_id }}">
              <td><input type="hidden" name="result_id[]" value="{{ $item->result_id }}">{{ $item->result->name }}</td>
              <td>
                <select name="type[]" id="type" class="form-control" required>
                  <option>Select Type</option>
                  <option value="1" {{ $item->result_type == 1 ? 'selected':'' }}>Input</option>
                    <option value="0" {{ $item->result_type == 0 ? 'selected':'' }}>Selected</option>
                </select>   
              </td>
              <td>
                <select name="heading_id[]" id="heading_id" class="form-control">
                    <option value="0">Select Heading</option>
                    @foreach ($test_result_heading as $heading)
                      <option value="{{ $heading->id }} {{ $heading->id == $item->heading_id ?'selected':'' }}">{{ $heading->name }}</option>
                    @endforeach
                </select>   
              </td>
              <td>
                <select name="unit[]" id="unit" class="form-control">
                    <option value="0">Select Unit</option>
                    @foreach ($units as $unit)
                      <option value="{{ $unit->id }} {{ $unit->id == $item->pathology_unit_id ?'selected':'' }}">{{ $unit->name }}</option>
                    @endforeach
                </select>    
              </td>
              <td><input type="text" name="cal_value[]" class="form-control"></td>
              <td><input type="text" name="cal_type[]" class="form-control"></td>
              <td>
                  <select name="convert_unit[]" id="corver_unit" class="form-control">
                    <option value="0">Select Unit</option>
                    @foreach ($units as $unit)
                      <option value="{{ $unit->id }} {{ $unit->id == $item->pathology_convert_unit_id ?'selected':'' }}">{{ $unit->name }}</option>
                    @endforeach  
                  </select>     
              </td>
              <td><input type="text" value="{{ $item->default_value }}" name="default_value[]" class="form-control"></td>
              <td><input type="text" value="{{ $item->normal_value }}" name="normal_value[]" class="form-control"></td>
              <td><button type="button" class="remove_tr"><i class="fa fa-trash text-danger"></i></button></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <x-button value="Save" />
    </x-form>
  </x-card>

  @push('js')
  <script>
    $(document).ready(function() {
      let headings = @json(App\Models\PathologyResultHeading::all());
      let units = @json(App\Models\PathologyUnit::all());
      let test = @json(App\Models\PathologyTest::all());
      $('select[name="category_id"]').on('change', function () {
        var Id = $(this).val();
        $('#test_name').html(null);
        test.filter(function(item){
            if((item.pathology_test_category_id == Id)) {
                return item;
            }
        }).map(function(item){
            $('#test_name').append(`<option value="${item.id}">${item.name}</option>`);
        });
        $('#test_name').val(0);
        $('#test_name').selectpicker("refresh");
      });


      $('select[name="result_id"]').on('change', function () {
        var selectedOption = $(this).find('option:selected');
        var Id = selectedOption.val();
        var name = selectedOption.text();
        var col = '';

        var selectedValue = $(this).val();
        var existingItem = $(`#test_setup_table_body tr[data-test-id="${selectedValue}"]`);
        if (existingItem.length === 0) {
        col += `
          <tr  data-test-id="${selectedValue}">
            <td><input type="hidden" name="result_id[]" value="${Id}">${name}</td>
            <td>
              <select name="type[]" id="type" class="form-control" required>
                <option>Select Type</option>
                <option value="1">Input</option>
                  <option value="0">Selected</option>
              </select>   
            </td>
            <td>
              <select name="heading_id[]" id="heading_id" class="form-control">
                  <option value="0">Select Heading</option>
                  ${
                      headings.map((item)=> `<option value=${item.id}>${item.name}</option>`)
                  }
              </select>   
            </td>
            <td>
              <select name="unit[]" id="unit" class="form-control">
                  <option value="0">Select Unit</option>
                  ${
                      units.map((item)=> `<option value=${item.id}>${item.name}</option>`)
                  }
              </select>    
            </td>
            <td><input type="text" name="cal_value[]" class="form-control"></td>
            <td><input type="text" name="cal_type[]" class="form-control"></td>
            <td>
                <select name="convert_unit[]" id="corver_unit" class="form-control">
                    <option value="0">Select Unit</option>
                    ${
                        units.map((item)=> `<option value=${item.id}>${item.name}</option>`)
                    }
                </select>     
            </td>
            <td><input type="text" name="default_value[]" class="form-control"></td>
            <td><input type="text" name="normal_value[]" class="form-control"></td>
            <td><button type="button" class="remove_tr"><i class="fa fa-trash text-danger"></i></button></td>
          </tr>
        `;
        }
        $('#test_setup_table_body').append(col);
      });
    });

    $(document).on('click','.remove_tr', function () {
      $(this).closest('tr').remove();
    });
  </script>
  @endpush

</x-admin>