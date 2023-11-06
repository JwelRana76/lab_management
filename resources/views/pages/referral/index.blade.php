<x-admin title="Referral">
    <x-page-header head="Referral" />
    <a href="{{ route('referral.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Referral
    </a>
    <div class="row">
      <x-data-table dataUrl="/referral" id="referrals" :columns="$columns" />
    </div>


    <x-modal id="referral_payment">
      <x-form action="{{ route('referral.payment.store') }}" method="post">
        <x-input id='referral_id' type="hidden" />
        <x-input id='due' type="hidden" />
        <x-input id='amount' />
        <x-button>Save</x-button>
      </x-form>
    </x-modal>
    <x-modal id="referral_payment_edit">
      <x-form action="{{ route('referral.payment.update') }}" method="post">
        <x-input id='payment_id' type="hidden" />
        <x-input id='amount' />
        <x-button>Update</x-button>
      </x-form>
    </x-modal>
    <x-modal id="referral_payment_details">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Paid By</th>
          <th>Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="referral_payment_table">

      </tbody>
    </table>
  </x-modal>
    @push('js')
        <script>
          function referralPayment(Id){
            $.get('/referral/due/'+Id,
            function(data){
              $('#due').val(data);
              $('#referral_id').val(Id);
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
            $.get('/referral/payment_details/'+Id,
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
                            <a class="dropdown-item" href="#" onclick="paymentEdit(${value.id})" data-target="#referral_payment_edit" data-toggle="modal" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
                            <a class="dropdown-item" href="#" onclick="deleteRecord(${value.id})">
                              <i class="fa fa-fw text-danger fa-trash"></i> Delete
                            </a>
                        </div>  
                      </div>
                    </td>
                  </tr>
                 `;
              });
              $('#referral_payment_table').append(payments);
            });
          }
          function paymentEdit(Id){
            $.get('/referral/payment/edit/'+Id,
            function(data){
              console.log(data);
              $('#payment_id').val(Id);
              $('#referral_payment_edit #amount').val(data.amount);
            });
            $('#referral_payment_details').modal('hide');
          }
          function deleteRecord(id) {
            var deleteUrl = '/referral/payment/delete/' + id;

            if (confirm('Are you sure to delete this record?')) {
              window.location.href = deleteUrl;
            }
          }
        </script>
    @endpush
</x-admin>