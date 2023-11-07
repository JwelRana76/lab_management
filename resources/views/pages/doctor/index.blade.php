<x-admin title="Doctor">
    <x-page-header head="Doctor" />
    <a href="{{ route('doctor.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Doctor
    </a>
    <div class="row">
      <x-data-table dataUrl="/doctor" id="doctors" :columns="$columns" />
    </div>

    <x-modal id="doctor_refer_payment">
      <x-form action="{{ route('doctor.payment.store') }}" method="post">
        <x-input id='doctor_id' type="hidden" />
        <x-input id='due' type="hidden" />
        <x-input id='amount' />
        <x-button>Save</x-button>
      </x-form>
    </x-modal>
    <x-modal id="doctor_refer_payment_edit">
      <x-form action="{{ route('doctor.payment.update') }}" method="post">
        <x-input id='payment_id' type="hidden" />
        <x-input id='amount' />
        <x-button>Update</x-button>
      </x-form>
    </x-modal>
    <x-modal id="doctor_refer_details">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Paid By</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="doctor_refer_payment_table">

        </tbody>
      </table>
    </x-modal>
    @push('js')
        <script>
          function referralPayment(Id){
            $.get('/doctor/due/'+Id,
            function(data){
              $('#due').val(data);
              $('#doctor_id').val(Id);
            });
          }
          $('input[name="amount"]').on('input', function () {
            var due = parseFloat($('input[name="due"]').val());
            var paid = parseFloat($(this).val());
            if(paid > due){
              alert(`You can't pay more than ${due}`);
              $(this).val(due);
            }
          });
          function referralPaymentDetails(Id){
            $.get('/doctor/payment_details/'+Id,
            function(data){
              console.log(data);
              var payments = '';
              $.each(data, function (index, value) { 
                payments += `<tr>
                    <td>${value.date.split(' ')[0]}</td>
                    <td>${value.username}</td>
                    <td>${value.amount || 'N/A'}</td>
                    <td>
                      <div class="btn-group dropleft">
                        <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-fw fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="paymentEdit(${value.id})" data-target="#doctor_refer_payment_edit" data-toggle="modal" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
                            <a class="dropdown-item" href="#" onclick="deleteRecord(${value.id})">
                              <i class="fa fa-fw text-danger fa-trash"></i> Delete
                            </a>
                        </div>  
                      </div>
                    </td>
                  </tr>
                 `;
              });
              $('#doctor_refer_payment_table').append(payments);
            });
          }
          function paymentEdit(Id){
            $.get('/doctor/payment/edit/'+Id,
            function(data){
              console.log(data);
              $('#payment_id').val(Id);
              $('#doctor_refer_payment_edit #amount').val(data.amount);
            });
            $('#doctor_refer_details').modal('hide');
          }
          function deleteRecord(id) {
            var deleteUrl = '/doctor/payment/delete/' + id;

            if (confirm('Are you sure to delete this record?')) {
              window.location.href = deleteUrl;
            }
          }
        </script>
    @endpush
</x-admin>