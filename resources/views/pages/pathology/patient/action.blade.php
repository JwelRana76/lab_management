<!-- Default dropleft button -->
<div class="btn-group dropleft">
    <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-fw fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('pathology.patient.edit',$item->id) }}" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
        <a class="dropdown-item" onclick="window.open('{{route('pathology.patient.invoice',$item->id)}}','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;" target="popup" href="#" ><i class="fa fa-fw text-primary fa-file"></i> Invoice</a>
        <a class="dropdown-item" href="{{ route('pathology.patient.delete',$item->id) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fa fa-fw text-danger fa-trash"></i> Delete</a>
    </div>   
</div>
