<x-admin title="Pathology Test Setup">
    {{-- <x-page-header head="Referral" /> --}}
  <x-card header="Pathology Test Setup" links="{{ route('pathology.test_setup.index') }}" title="Test Setup List">
    <x-form action="{{ route('pathology.test_setup.store') }}" method="post">
      <div class="row">
        <div class="col-md-6">
          <x-select id="category_name" name="category_id" :options="$category" required />
        </div>
        <div class="col-md-6">
          <x-select id="test_name" name="test_id" :options="[]" required />
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
          <tbody id="test_setup_table_body">
            
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
        var Id = $(this).val();
        var name = $(this).text();
        var col = '';
        col += `
          <tr>
            <td><input type="hidden" name="result_id[]" value="${Id}">${name}</td>
            <td>
              <select name="type[]" id="type" class="form-control">
                  <option>Select Type</option>
                  <option value="0">Selected</option>
                  <option value="1">Input</option>
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
                  <option>Select Unit</option>
                  ${
                      units.map((item)=> `<option value=${item.id}>${item.name}</option>`)
                  }
              </select>    
            </td>
            <td><input type="text" name="cal_value[]" class="form-control"></td>
            <td><input type="text" name="cal_type[]" class="form-control"></td>
            <td>
                <select name="corver_unit[]" id="corver_unit" class="form-control">
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
        $('#test_setup_table_body').append(col);
      });
    });

    $(document).on('click','.remove_tr', function () {
      $(this).closest('tr').remove();
    });
  </script>
  @endpush

</x-admin>