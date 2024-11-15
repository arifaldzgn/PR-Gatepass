@extends('layouts.main')

@include('layouts.partials.pr_modals')

@section('container')


<main class="p-4 min-vh-200">

    <section class="row">
        <div class="col-md-6 col-lg-4">
            <article class="p-4 rounded shadow-sm border-left-card mb-4">
                <a href="#" class="d-flex align-items-center">
                    <span class="bi bi-list-task h4 text-success"></span>
                    <h5 class="ml-3 text-success"  data-toggle="modal" data-target="#createPr">Create New Purchase Requisition</h5>
                </a>
            </article>
        </div>
    </section>

    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped display compact" style="width:100%">
            <thead>
                <tr>
                    <th>Request Date</th>
                    <th>Ticket Code</th>
                    <th>Requestor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataT as $dT)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($dT->created_at)->format('d F Y, h:i A') }}</td>
                    <td>{{ $dT->ticketCode }}</td>
                    <td>{{ $dT->user->name }}</td>
                    <td>
                        @if ($dT->status === 'Pending' or $dT->status === 'Revised')
                        <span class="badge badge-pill badge-secondary">{{ $dT->status }}</span>
                        @elseif($dT->status === 'Rejected')
                        <span class="badge badge-pill badge-danger">{{ $dT->status }}</span>
                        @else
                        <span class="badge badge-pill badge-success">{{ $dT->status }}</span>
                        @endif
                    </td>
                    {{-- <td>
                        <center>
                            @if ($dT->status === 'Pending' or $dT->status === 'Revised')
                            <button class="updateBtn btn btn-primary" data-request-id="{{ $dT->id }}"><i class="bi bi-pencil-square"></i></button>
                            <button class="delete-btn btn btn-danger" data-item-id="{{ $dT->id }}"><i class="bi bi-trash"></i></button>
                            @else
                            -
                            @endif
                        </center>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</main>







@endsection

@section('script')


<script>


    jQuery(document).ready(function($) {

        $('#submitRequest').click(function() {
        var formData = $('#createPrForm').serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });

            $.ajax({
                url: '/ticket',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire('Success', response.message, 'success').then(function(){
                        location.reload();
                    });;
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', xhr.responseJSON.error, 'error');
                }
                });
        });


        var arrayCount = 1;
        var itemCount = 2;

        $.noConflict();

        function initializeSelectpicker() {
            $('.selectpicker').selectpicker('refresh');
        }

        function fillOtherFields(partName, arrayCount) {
            // Make an AJAX request to retrieve data based on partName
            $.ajax({
                url: '{{ route('retrieve.part.details') }}',
                method: 'GET',
                data: { partName: partName },
                success: function(data) {
                    $(`input[name="pr_request[${arrayCount}][UoM]"]`).val(data.part.UoM);
                    console.log(data.stock);
                    console.log(arrayCount);
                    $(`input[name="pr_request[${arrayCount}][requires_stock_reduction]"]`).val(data.stock);
                    $(`input[name="pr_request[${arrayCount}][category]"]`).val(data.part.category);
                    $(`textarea[name="pr_request[${arrayCount}][type]"]`).val(data.part.type);
                    $(`input[name="pr_request[${arrayCount}][partlist_id]"]`).val(data.part.id);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle error
                }
            });
        }

        // Event handler for adding new item
        $("#addItem").click(function() {
            if (arrayCount <= 5) {
                var newItem = `
                <div class="card card-body border border-primary">
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Part/Service Name</label>
                            <select class="form-control selectpicker" multiple data-max-options="1" name="pr_request[${arrayCount}][part_name]" data-live-search="true" onchange="" data-array-count="${arrayCount}">
                                @foreach ($dataR as $dR)
                                <option value="{{ $dR->id }}">{{ $dR->part_name }}</option>
                                @endforeach
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Part/Service not available? <a href="{{ route('partlist')}}" class="text-primary">Click here</a> to add new data.</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="typeNumber">Amount / 1 Item (Rp)</label>
                        <input type="text" id="typeNumber" class="form-control" name="pr_request[${arrayCount}][amount]" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="typeNumber">Quantity</label>
                        <input type="number" min="1" class="form-control qty-input" name="pr_request[${arrayCount}][qty]" data-array-count="${arrayCount}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vendor</label>
                        <input type="text" class="form-control" name="pr_request[${arrayCount}][vendor]">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stocks</label>
                        <input type="text" class="form-control" id="requires_stock_reduction" name="pr_request[${arrayCount}][requires_stock_reduction]" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UoM</label>
                        <input type="text" class="form-control" id="UoM" name="pr_request[${arrayCount}][UoM]" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="pr_request[${arrayCount}][category]" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description/Others</label>
                        <textarea type="text" class="form-control" id="type" name="pr_request[${arrayCount}][type]" placeholder="Type" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remark</label>
                        <input type="text" class="form-control" name="pr_request[${arrayCount}][remark]">
                        <input type="hidden" class="form-control" name="pr_request[${arrayCount}][partlist_id]">
                        <input type="hidden" class="form-control" name="pr_request[${arrayCount}][other_cost]" value="0">
                        <input type="hidden" class="form-control" name="pr_request[${arrayCount}][tag]" value="0">
                    </div>
                </div>
                <br>
            `;
            $("#prRequestForm").append(newItem);
            arrayCount++;
            itemCount++;

            $('#submitRequest').prop('disabled', false);

            initializeSelectpicker();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Maximum is 5',
                    text: 'Maximum items have been reached, Failed to add new request.'
                });
            }
        });

        $(document).on('change', '.selectpicker', function() {
            var partName = $(this).val();
            var arrayCount = $(this).attr('data-array-count');
            fillOtherFields(partName, arrayCount);
        });

        $(document).on('input', '.qty-input', function() {
            var qty = $(this).val();
            var arrayCount = $(this).data('array-count');
            var requiresStockReduction = $(`input[name="pr_request[${arrayCount}][requires_stock_reduction]"]`).val();

            if (requiresStockReduction !== "false" && qty > parseInt(requiresStockReduction)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Exceeds Available Stock',
                    text: `The quantity cannot exceed the available stock of ${requiresStockReduction}.`
                });
                $(this).val(''); // Clear the invalid input
            }
        });

        initializeSelectpicker();
    });

// Show Details Material Button
$('.updateBtn').click(function() {
    var requestId = $(this).data('request-id');
    $('#approveButton').data('request-id', requestId);
    $('#rejectButton').data('request-id', requestId);

    $.ajax({
        url: '/ticketDetails/' + requestId,
        method: 'GET',
        success: function(response) {
            $('#materialDataForm').empty();
            var itemCount = 1;
            var materialCount = 0;

            $.each(response, function(index, pr_request) {
                var id = pr_request.partlist_id;

                $.ajax({
                    url: '/retrieve-part-name/' + id,
                    method: 'GET',
                    success: function(partName) {

                        var cardHeader =
                        '<div class="card-header">' +
                            'Part Request No. '+ itemCount +
                            '<button type="button" class="close" aria-label="Close" data-part-id="'+ pr_request.id +'">' +
                                '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                        '</div>';

                        var row =
                            '<div class="card mb-3 border-primary">' +
                            cardHeader +
                            '<div class="card-body">' +
                                '<div class="mb-3">' +
                                    '<label for="materialName" class="form-label">Requested Part Name :</label>' +
                                    '<input type="text" class="form-control mb-2" id="materialName" name="pr_request['+materialCount+'][material_name]" value="'+partName+'" readonly>' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Quantity</label>' +
                                    '<input type="number" class="form-control" id="requestedQuantity" name="pr_request['+materialCount+'][qty]" value="'+pr_request.qty+'">' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Amount / 1 Item (Rp)</label>' +
                                    '<input type="number" class="form-control" id="requestedAmount" name="pr_request['+materialCount+'][amount]" value="'+pr_request.amount+'">' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Other Cost</label>' +
                                    '<input type="number" class="form-control" id="requestedOtherCost" name="pr_request['+materialCount+'][other_cost]" value="'+pr_request.other_cost+'">' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Vendor</label>' +
                                    '<input type="text" class="form-control" id="requestedVendor" name="pr_request['+materialCount+'][vendor]" value="'+pr_request.vendor+'">' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Remark</label>' +
                                    '<input type="text" class="form-control" id="requestedRemark" name="pr_request['+materialCount+'][remark]" value="'+pr_request.remark+'">' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Category</label>' +
                                    '<input type="text" class="form-control" id="requestedCategory" name="pr_request['+materialCount+'][category]" value="'+pr_request.category+'">' +
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<label for="materialQuantity" class="form-label">Tag</label>' +
                                    '<input type="text" class="form-control" id="requestedTag" name="pr_request['+materialCount+'][tag]" value="'+pr_request.tag+'">' +
                                '</div>' +
                                '<input type="hidden" class="form-control" name="pr_request['+materialCount+'][id]" value="'+pr_request.id+'">' +
                                '<input type="hidden" class="form-control" name="pr_request['+materialCount+'][ticket_id]" value="'+pr_request.ticket_id+'">' +
                            '</div>' +
                            '</div>';

                        $('#materialDataForm').append(row);
                        itemCount++;
                        materialCount++;
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $('#materialModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle error
        }
    });
});

    // Save
    $('#saveMaterialChanges').click(function() {
        // console.log('saveMaterial');
        var formData = $('#materialDataForm').serialize();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/updateTicket',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Success'
                    }).then(function(){
                        location.reload();
                    });;
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update material data'
                });
            }
            });
    });

    // Delete Confirmation Modal & Button
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('deleteModal');

        var deleteButtons = document.querySelectorAll('.delete-btn');

        var itemId;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                itemId = button.getAttribute('data-item-id');
                modal.style.display = 'block';
            });
        });

        // Delete
        var confirmDeleteBtn = document.getElementById('confirmDelete');

        confirmDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            deleteItem(itemId);
        });

        // Cancel
        var cancelDeleteBtn = document.getElementById('cancelDelete');

        cancelDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        function deleteItem(itemId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });
            $.ajax({
                url: '/ticket/' + itemId,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Ticket successfully deleted'
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

    // Reject
    $('#rejectButton').click(function() {
        var requestId = $(this).data('request-id');
        console.log(requestId);

        $('#rejectReasonModal').modal('show');
        $('#materialModal').modal('hide');

        $('#confirmRejectButton').click(function() {
            var rejectReason = $('#rejectReasonTextarea').val();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: '/ticket/' + requestId + '/reject',
                method: 'PUT',
                data: { reason: rejectReason },
                success: function(response) {
                    Swal.fire("Success", response.message, "success").then(function(){
                        location.reload();
                    });;;

                    $('#materialModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire("Error", "Failed to reject request", "error");
                }
            });
        });
    });

    // Approve
    $('#approveButton').click(function() {
        var requestId = $(this).data('request-id');
        console.log(requestId);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $.ajax({
            url: '/ticket/' + requestId + '/approve',
            method: 'PUT',
            success: function(response) {
                Swal.fire("Success", response.message, "success");

                $('#materialModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire("Error", "Failed to approve request", "error");
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const switchCheckbox = document.getElementById('flexSwitchCheckDefault');
        const inputField = document.getElementById('cashAdvance');

        switchCheckbox.addEventListener('change', function() {
            if (this.checked) {
            inputField.disabled = false;
            } else {
            inputField.disabled = true;
            }
        });
    });

</script>

@endsection
