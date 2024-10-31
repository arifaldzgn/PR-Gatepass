@extends('layouts.main')
@extends('layouts.partials.pr_modals')

@section('container')

<main class="p-4 min-vh-200">

    <div class="col-lg-5">
        <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm ">
            <h2 class="ml-4 text-primary">Pending GatePass Requsest</h2>
            <small class="ml-4 form-text text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, itaque.</small>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped display compact" style="width:100%">
            <thead>
                <tr>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Requested by</th>
                    <th><center>Office no</center></th>
                    <th>Company name</th>
                    <th>Company address</th>
                    <th><center>Requested Items</center></th>
                    <th><center>Action</center></th>
                </tr>
            </thead>
            {{-- @if (auth()->user()->role === 'security')

            @else

            @endif --}}
            <tbody>
                @foreach ($data as $d)
                <tr>
                        <td>{{ $d->created_at }}</td>
                        <td>
                            @if ($d->status === 'Pending' or $d->status === 'Revised')
                                <span class="badge badge-pill badge-secondary">{{ $d->status }}, waiting for approval</span>
                            @elseif($d->status === 'Rejected')
                                <span class="badge badge-pill badge-danger">{{ $d->status }}</span>
                            @else
                                @if ($d->approved_user_id !== null && $d->checked_user_id !== null)
                                    <span class="badge badge-pill badge-success">Granted by Security</span>
                                @elseif($d->approved_user_id !== null)
                                    <span class="badge badge-pill badge-primary">Approved, waiting for security verification</span>
                                @endif
                            @endif
                        </td>
                        <td>{{ App\Models\User::find($d->user_id)->name }}</td>
                        <td>{{ $d->ticket }}</td>
                        <td>{{ $d->company_name }}</td>
                        <td>{{ $d->company_address }}</td>
                        <td>{{ $d->company_employee }}</td>
                        @if(auth()->user()->role === 'security')
                        <td>
                            <a class="btn btn-success" href="verif_gatepass/{{$d->ticket}}"><i class="bi bi-patch-check"></i></a>
                        </td>
                        @elseif($d->user_id === auth()->user()->id)
                        <td>
                            <a class="btn btn-primary" href="edit_gatepass/{{$d->ticket}}"><i class="bi bi-pencil"></i></a>
                            <a class="btn btn-danger delete-btn" data-item-id="{{ $d->id }}"><i class="bi bi-trash3"></i></a>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" tabindex="-1" id="gatepassDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeDeletePass">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDeletePass">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePass">Delete</button>
                </div>
            </div>
        </div>
    </div>




</main>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalPass = document.getElementById('gatepassDelete');

        var deleteButtons = document.querySelectorAll('.delete-btn');

        var itemId;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                itemId = button.getAttribute('data-item-id');
                console.log(itemId);
                modalPass.style.display = 'block';
            });
        });

        // Delete
        var confirmDeletePassBtn = document.getElementById('confirmDeletePass');

        confirmDeletePassBtn.addEventListener('click', function() {
            modalPass.style.display = 'none';
            deleteItem(itemId);
        });

        // Cancel
        var cancelDeletePassBtn = document.getElementById('cancelDeletePass');

        cancelDeletePassBtn.addEventListener('click', function() {
            modalPass.style.display = 'none';
        });

        // Close
        var closeDeletePassBtn = document.getElementById('closeDeletePass');

        closeDeletePassBtn.addEventListener('click', function() {
            modalPass.style.display = 'none';
        });

        function deleteItem(itemId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });
            $.ajax({
                url: '/delete_gatepass/' + itemId,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'GatePass request successfully deleted'
                    }).then(function(){
                        location.reload();
                    });;
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to delete ticket', 'error');
                }
            });
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
@endsection
