<!-- Default dropleft button -->
<div class="btn-group dropleft">
    <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-fw fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('doctor.edit',$item->id) }}"><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
        @if ($item->due > 0)
        <a class="dropdown-item" href="" data-target="#doctor_refer_payment" data-toggle="modal" onclick="referralPayment({{ $item->id }})"><i class="fa fa-fw text-primary fa-dollar-sign"></i> Payment</a>
        @endif
        @if ($item->payment()->sum('amount') > 0)
        <a class="dropdown-item" href="" data-target="#doctor_refer_details" data-toggle="modal" onclick="referralPaymentDetails({{ $item->id }})"><i class="fa fa-fw text-primary fa-dollar-sign"></i> Payment Details</a>
        @endif
        <a class="dropdown-item" href="{{ route('doctor.delete',$item->id) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fa fa-fw text-danger fa-trash"></i> Delete</a>
    </div>  
</div>
