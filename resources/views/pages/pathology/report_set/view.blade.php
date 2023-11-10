<x-admin title="Pathology Report">
    <x-page-header head="Pathology Report" />
    
    <div class="row">
      <x-data-table dataUrl="/pathology/report/view" id="pathologyReportview" :columns="$columns" />
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
          <x-form action="{{ route('report_set.update') }}" method="post">
          @foreach ($patient_tests as $test)
              <h4>Test Name : {{ $test->test->name }}</h4>
              @php
                $test_setup = App\Models\PathologyTestSetup::where('test_id',$test->test_id)->first();
              @endphp
              <input type="hidden" name="patient_id" value="{{ request()->patient_id }}">
              <input type="hidden" name="test_id[]" value="{{ $test->test_id }}">
              <table class="table">
                @if ($test_setup)
                @foreach ($test_setup->resutlName as $result)
                  @php
                    $resutl_value = App\Models\PathologyPatientReportValue::join('pathology_patient_reports','pathology_patient_reports.id','pathology_patient_report_values.report_id')
                    ->where('pathology_patient_reports.patient_id',request()->patient_id)
                    ->where('pathology_patient_report_values.result_id',$result->result_id)->first();
                  @endphp
                    <tr>
                      <th>
                        {{ $result->result->name }} 
                      </th>
                      <th>:</th>
                      <th>
                      @if ($result->result_type == 1)
                        <input type="text" class="form-control" name="result_value[{{ $test->test_id }}][{{ $result->result_id }}]" 
                        value="{{ $resutl_value->result_value ?? 'N/A' }}"
                        {{ request()->has('view') == true ? 'readonly':'' }}
                        >
                      @endif
                      </th>
                    </tr>
                @endforeach
                @else
                    <h6>This Test in not setuped</h6>
                @endif
              </table>
          @endforeach
          <x-button>Submit</x-button>
          </x-form>
        </x-card>
      </div>
    </div>
  @endif

  <x-modal id="report_print">
    <x-form action="{{ route('report_set.print') }}" method="get" target="_blank">
      <input type="hidden" name="patient_id" id="patient_id">
      <div class="test_list">

      </div>
      <x-button id="print_button"/>
    </x-form>
  </x-modal>
  

  @push('js')
      <script>
        let hasId = @json($patient_id ?? false);
        
        if(hasId != false){
            print_report(hasId);
        }
        function print_report(Id){
            console.log(Id);
            $('.test_list').html(null);
            $('#report_print').modal('show');
            $.get("/pathology/report/findtest/"+Id,
                function (item) {
                    item.map(function(test){
                        $('#patient_id').val(Id);
                        $('.test_list').append(`
                            <div class="">
                                <input type="checkbox" name="test_id[]" value="${test.id}" class="mr-3"><label>${test.name}</label>
                            </div>
                        `);
                    })
                }
            );
            
        }
        $('#print_button').on('click', function () {
          $('#report_print').modal('hide');
        });
      </script>
  @endpush

</x-admin>