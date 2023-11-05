<x-admin title="Due Collection">
    <x-card header="Due Collection">
      <div class="col-md-6 col-sm-12 m-auto">
        <div class="form-group">
          <label for="exampleFormControlSelect1">Select Patient</label>
          <select class="form-control selectpicker" id="patient" name="patient_id" data-live-search="true" title="Choice Patient" >
            @foreach ($patients as $patient)
              <option value="{{ $patient->id }}">{{ $patient->name }}[{{ $patient->unique_id }}]</option>
            @endforeach
          </select>
        </div>
      </div>
      @if (request()->patient_id)
          @php
            $patient = App\Models\PathologyPatient::findOrFail(request()->patient_id);
          @endphp
          <table class="table mt-5">
            <thead>
              <tr>
                <th>Patient Unique Id</th>
                <th>:</th>
                <th>{{ $patient->unique_id }}</th>
                <th>Patient Name</th>
                <th>:</th>
                <th>{{ $patient->name }}</th>
              </tr>
              <tr>
                <th>Patient Contact</th>
                <th>:</th>
                <th>{{ $patient->contact }}</th>
                <th>Patient Age</th>
                <th>:</th>
                <th>{{ $patient->age }} {{ $patient->age_type == 1 ? 'Days' : ($patient->age_type == 2 ? 'Months':'Years') }}</th>
              </tr>
              <tr>
                <th>Grand Total</th>
                <th>:</th>
                <th>{{ $patient->grand_total }}</th>
                <th>Test Discount</th>
                <th>:</th>
                <th>{{ $patient->discount_amount }}</th>
              </tr>
              <tr>
                <th>Paid Amount</th>
                <th>:</th>
                <th>{{ $patient->payment()->sum('amount') }}</th>
                <th>Test Due</th>
                <th>:</th>
                <th>{{ $patient->due }}</th>
              </tr>
              <x-form action="{{ route('due_collection.store',$patient->id) }}" method="post">
              <tr>
                <th>Provide Discount</th>
                <th>:</th>
                <th>
                  <input type="text" name="discount" class="form-control">
                  <input type="hidden" name="due" value="{{ $patient->due }}" class="form-control">
                  <input type="hidden" name="previous_discount" value="{{ $patient->discount_amount }}" class="form-control">
                  <input type="hidden" name="max_discount" value="{{ $patient->maxdiscount }}" class="form-control">
                </th>
                <th>Paid Amount</th>
                <th>:</th>
                <th>
                  <input type="text" name="amount" class="form-control" required>
                </th>
              </tr>
              <tr class="text-right">
                <th colspan="6"><x-button class="btn btn-primary btn-sm">Submit</x-button></th>
              </tr>
              </x-form>
            </thead>
          </table>
          
      @endif
    </x-card>

    @push('js')
        <script>
          $('select[name="patient_id"]').on('change', function() {
            var selectedPatientId = $(this).val(); // Get the selected value
            var currentURL = window.location.href;

            // Use the URLSearchParams API to work with the query parameters
            var searchParams = new URLSearchParams(currentURL);

            // Update the 'patient_id' query parameter with the selected value
            searchParams.set('patient_id', selectedPatientId);

            // Get the modified query string
            var newQueryString = searchParams.toString();

            // Replace the current URL with the updated query string
            var newURL = currentURL.split('?')[0] + '?' + newQueryString;
            window.location.href = newURL;
          });

          $('input[name="amount"],input[name="discount"]').on('input', function () {
            amountvaliation(parseFloat($(this).val() || 0));
          });

          function amountvaliation(amount){
            var due = parseFloat($('input[name="due"]').val());
            var previous_discount = parseFloat($('input[name="previous_discount"]').val());
            var max_discount = parseFloat($('input[name="max_discount"]').val());
            var discountable = max_discount - previous_discount;

            var discount = parseFloat($('input[name="discount"]').val() || 0);
            var paid = parseFloat($('input[name="amount"]').val() || 0);

            if(amount == discount){
              var big = due > discountable ? discountable:due;
              if (big < amount) {
                alert(`You can't provide discount more than ${big}`);
                $('input[name="discount"]').val(big);
                $('input[name="amount"]').val(due - big);
                amountvaliation();
              }else{
                $('input[name="amount"]').val(due - amount);
              }
            }else{
              var mx = due - discount
              if(amount > mx){
                alert(`You can't paid more than ${mx}`);
                $('input[name="amount"]').val(mx);
                amountvaliation(mx);
              }
            }
          }
        </script>
    @endpush
</x-admin>