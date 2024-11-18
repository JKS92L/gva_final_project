@php $serialNo = 1; @endphp <!-- Initialize serial number -->

@foreach($filteredRecords as $record)
    <tr>
        <td>{{ $serialNo++ }}</td> <!-- Serial number column -->
        <td>{{ $record->student->firstname }} {{ $record->student->lastname }}</td>
        <td>{{ $record->deposit_date->format('Y-m-d') }}</td>
        <td>{{ $record->deposit_amount }}</td>
        <td>{{ $record->bank_account }}</td>
        <td>{{ $record->receipt_number }}</td>
        <td>{{ $record->deposit_description }}</td>
        
        <!-- Action buttons -->
        <td>
            <!-- Edit Button with Modal Trigger -->
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editReconciliationModal-{{ $record->id }}">
                Edit
            </button>

            <!-- Delete Button with Confirmation -->
            <form action="{{ route('accounts.expenses.bank-reconciliation.destroy', $record->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">
                    Delete
                </button>
            </form>
        </td>
    </tr>
@endforeach

<script>
    function confirmDelete(form) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
