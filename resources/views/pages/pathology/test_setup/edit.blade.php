<x-admin title="Pathology Test Edit">
    {{-- <x-page-header head="Referral" /> --}}
  <x-card header="Pathology Test Edit" links="{{ route('test.index') }}" title="Test List">
    <x-form action="{{ route('test.update',$test->id) }}" method="post">
      <div class="row">
        <x-input id="name" value="{{ $test->name }}" class="col-md-4" required />
        <x-input id="code" value="{{ $test->code }}" class="col-md-4" required />
        <div class="col-md-4">
          <x-select id="category" selectedId="{{ $test->pathology_test_category_id }}" name="category_id" :options="$category" class="col-md-4" has-modal modal-open-id="create_category" />
        </div>
        <x-input id="test_rate" value="{{ $test->test_rate }}" class="col-md-4" required />
        <x-input id="referral_fee_percent" value="{{ $test->referral_fee_percent }}" class="col-md-4" required />
      </div>
      <x-button value="Save" />
    </x-form>
  </x-card>
  
  <x-modal id="create_category">
    <form id="categoryForm">
      @csrf
      <x-input id="category_name" required />
      <x-input id="category_code" required />
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </x-modal>

  @push('js')
  <script>
    // Wait for the document to be ready
    $(document).ready(function() {
      // Add an event listener to the form's submit event
      $('#categoryForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Collect the form data
        var formData = {
          _token: $('input[name="_token"]').val(),
          category_name: $('#category_name').val(),
          category_code: $('#category_code').val()
        };

        // Use AJAX to send the data to the server
        $.ajax({
          type: 'POST',
          url: '{{ route("test_category.store") }}',
          data: formData,
          success: function(response) {
            // Handle the success response here
            console.log(response);
            $('#create_category').modal('hide');
            updateCategorySelect(response);

            var lastCategoryId = response[response.length - 1].id;
            var selectElement = $('#category'); // Use the correct selector
            selectElement.selectpicker('val', lastCategoryId);
          },
          error: function(error) {
            // Handle any errors here
            console.error(error);
          }
        });
      });
    });

    function updateCategorySelect(categories) {
            // Assuming "categories" is an array of objects with "id" and "name" fields
            var $categorySelect = $('#category');
            $categorySelect.empty(); // Clear the current options

            // Add the new options
            categories.forEach(function(category) {
                $categorySelect.append(
                    $('<option>', {
                        value: category.id,
                        text: category.name
                    })
                );
            });

            // Update the selectpicker
            $categorySelect.selectpicker('refresh');
        }
  </script>
  @endpush

</x-admin>