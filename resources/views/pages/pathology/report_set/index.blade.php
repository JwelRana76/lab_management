<x-admin title="Pathology Report Set">
    <x-page-header head="Pathology Report Set" />
    
    <div class="row">
      <x-data-table dataUrl="/pathology/report-set" id="pathologyReportSet" :columns="$columns" />
    </div>
  @if (request()->patient_id)
      
    <div class="row mt-3">
      <div class="col-md-12">
        <x-card header="Patient Details">
          @php
            $patient = App\Models\PathologyPatient::findOrFail(request()->patient_id);
            $patient_tests = App\Models\PatientTest::where('patient_id',request()->patient_id)->get();
          @endphp
          <table class="table">
            <thead>
              <tr>
                <th>Unique Id</th>
                <th>:</th>
                <th>{{ $patient->unique_id }}</th>
                <th>Patient Age</th>
                <th>:</th>
                <th>{{ $patient->age }} {{ $patient->age_type == 1 ?'Days':($patient->age_type == 2 ? 'Months':'Years') }}</th>
              </tr>
              <tr>
                <th>Patient Name</th>
                <th>:</th>
                <th>{{ $patient->name }}</th>
                <th>Patient Contact</th>
                <th>:</th>
                <th>{{ $patient->contact }}</th>
              </tr>
            </thead>
          </table>
          <hr>
          @foreach ($patient_tests as $test)
              <h4>Test Name : {{ $test->test->name }}</h4>
              <x-form action="{{ route('report_set.store') }}" method="post">
              @php
                $test_setup = App\Models\PathologyTestSetup::where('test_id',$test->test_id)->first();
              @endphp
              <input type="hidden" name="test_id[]" value="{{ $test->test_id }}">
              <table class="table">
                @if ($test_setup)
                @foreach ($test_setup->resutlName as $result)
                    <tr>
                      <th>
                        {{ $result->result->name }} 
                      </th>
                      <th>:</th>
                      <th>
                      @if ($result->result_type == 1)
                        <input type="text" class="form-control" name="result_value[{{ $test->test_id }}][{{ $result->result_id }}]" value="{{ $result->default_value??"N/A" }}">
                      @endif
                      </th>
                    </tr>
                @endforeach
                @else
                    <h6>This Test in not setuped</h6>
                @endif
              </table>
              <x-button>Submit</x-button>
              </x-form>
          @endforeach
        </x-card>
      </div>
    </div>
  @endif

  

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