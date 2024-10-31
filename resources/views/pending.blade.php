@extends('layouts.main')

@include('layouts.partials.pr_modals')

@section('container')


<main class="p-4 min-vh-200">

    <div class="col-lg-5">
        <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm ">
            <h2 class="ml-4 text-primary">Pending PR Ticket</h2>
            <small class="ml-4 form-text text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, itaque.</small>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped display compact" style="width:100%">
            <thead>
                <tr>
                    <th>Request Date</th>
                    <th>Ticket Code</th>
                    <th>Requestor</th>
                    <th>Status</th>
                    <th class="t-center"><center>Action</center></th>
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
                        @else
                        <span class="badge badge-pill badge-success">{{ $dT->status }}</span>
                        @endif
                    </td>
                    <td>
                        <center>
                            @if ($dT->status === 'Pending' or $dT->status === 'Revised')
                            <button onclick="console.log({{$dT->id}})" class="updateBtn btn btn-primary" data-request-id="{{ $dT->id }}"><i class="bi bi-pencil-square"></i></button>
                            <button class="delete-btn btn btn-danger" data-item-id="{{ $dT->id }}"><i class="bi bi-trash"></i></button>
                            @else
                            -
                            @endif
                        </center>
                    </td>
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'New Part successfully added'
                }).then(function(){
                    location.reload();
                });;
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add new part'
                });
            }
            });
    });

    var arrayCount = 1;
    var itemCount = 2;

    $.noConflict();

    // Function to initialize selectpicker
    function initializeSelectpicker() {
        $('.selectpicker').selectpicker('refresh');
    }

    // Function to handle filling other fields based on selected part_name
    function fillOtherFields(partName, arrayCount) {
        // Make an AJAX request to retrieve data based on partName
        $.ajax({
            url: '{{ route('retrieve.part.details') }}',
            method: 'GET',
            data: { partName: partName },
            success: function(data) {
                // Populate other fields based on retrieved data
                $(`input[name="pr_request[${arrayCount}][UoM]"]`).val(data.UoM);
                console.log(data.UoM);
                console.log(arrayCount);
                $(`input[name="pr_request[${arrayCount}][requires_stock_reduction]"]`).val(data.requires_stock_reduction);
                $(`input[name="pr_request[${arrayCount}][category]"]`).val(data.category);
                $(`textarea[name="pr_request[${arrayCount}][type]"]`).val(data.type);
                $(`input[name="pr_request[${arrayCount}][partlist_id]"]`).val(data.id);
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle error
            }
        });
    }



    // Event listener for change on part_name select
    $(document).on('change', '.selectpicker', function() {
        var partName = $(this).val();
        var arrayCount = $(this).attr('data-array-count');
        fillOtherFields(partName, arrayCount);
    });

    // Initialize selectpicker on page load
    initializeSelectpicker();
});

$(document).ready(function() {
    $('.updateBtn').click(function() {
        var requestId = $(this).data('request-id');
        $('#approveButton').data('request-id', requestId);
        $('#rejectButton').data('request-id', requestId);
        console.log('ID: ' + requestId);
        $.ajax({
            url: '/ticketDetails/' + requestId,
            method: 'GET',
            success: function(response) {
                // Populate the advance_cash field
                $('#typeNumber').val(response.advance_cash);

                $('#materialDataForm').empty();
                var itemCount = 1;
                var materialCount = 0;

                $.each(response.pr_requests, function(index, pr_request) {
                    var id = pr_request.partlist_id;

                    $.ajax({
                        url: '/retrieve-part-name/' + id,
                        method: 'GET',
                        success: function(data) {
                            var cardHeader =
                            '<div class="card-header">' +
                                'Part Request No. ' + itemCount +
                                '<button type="button" class="btn btn-sm close" aria-label="Close" data-delete-id="'+ pr_request.id +'"' + (response.pr_requests.length === 1 ? 'disabled' : '') + '>' +
                                    '<i class="bi bi-trash"></i>' +
                                '</button>' +
                            '</div>';

                            // Ensure availableStock is a valid number
                            var initialQuantity = parseInt(pr_request.qty);
                            var availableStock = parseInt(data.stock);
                            if (isNaN(availableStock)) {
                                availableStock = 'NaN'; // Default to NaN if not a valid number
                            }
                            var totalStock = initialQuantity + (isNaN(availableStock) ? 0 : availableStock);

                            // Create and append row inside the success function
                            var row =
                                '<div class="card mb-3 border-primary">' +
                                cardHeader +
                                '<div class="card-body">' +
                                    '<div class="mb-3">' +
                                        '<label for="materialName" class="form-label">Requested Part Name :</label>' +
                                        '<input type="text" class="form-control mb-2" id="materialName" name="pr_request[' + materialCount + '][material_name]" value="'+ data.part_name +'" readonly>' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Category</label>' +
                                        '<input type="text" class="form-control" id="requestedCategory" name="pr_request[' + materialCount + '][category]" value="'+ pr_request.category +'" readonly>' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Available Stock</label>' +
                                        '<input type="text" class="form-control" id="availStock' + materialCount + '" name="pr_request[' + materialCount + '][requires_stock_reduction]" value="'+ (isNaN(availableStock) ? 'N/A' : availableStock) +'" disabled>' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Requested Quantity</label>' +
                                        '<input type="number" class="form-control requested-quantity" id="requestedQuantity' + materialCount + '" name="pr_request[' + materialCount + '][qty]" value="'+ pr_request.qty +'" data-initial-quantity="'+ pr_request.qty +'" data-total-stock="'+ totalStock +'" data-pr-id="'+ pr_request.id +'" data-available-stock="'+ availableStock +'" min=0>' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Amount (Rp.)</label>' +
                                        '<input type="number" class="form-control" id="requestedAmount" name="pr_request[' + materialCount + '][amount]" value="'+ pr_request.amount +'">' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Other Cost</label>' +
                                        '<input type="number" class="form-control" id="requestedOtherCost" name="pr_request[' + materialCount + '][other_cost]" value="'+ pr_request.other_cost +'">' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Vendor</label>' +
                                        '<input type="text" class="form-control" id="requestedVendor" name="pr_request[' + materialCount + '][vendor]" value="'+ pr_request.vendor +'">' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Remark</label>' +
                                        '<input type="text" class="form-control" id="requestedRemark" name="pr_request[' + materialCount + '][remark]" value="'+ pr_request.remark +'">' +
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<label for="materialQuantity" class="form-label">Tag</label>' +
                                        '<input type="text" class="form-control" id="requestedTag" name="pr_request[' + materialCount + '][tag]" value="'+ pr_request.tag +'">' +
                                    '</div>' +
                                    '<input type="hidden" class="form-control" name="pr_request[' + materialCount + '][id]" value="'+ pr_request.id +'">' +
                                    '<input type="hidden" class="form-control" name="pr_request[' + materialCount + '][ticket_id]" value="'+ pr_request.ticket_id +'">' +
                                    '<input type="hidden" class="form-control" name="pr_request[' + materialCount + '][partlist_id]" value="'+ pr_request.partlist_id +'">' +
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

    $(document).on('input', '.requested-quantity', function() {
        var requestedQuantity = parseInt($(this).val());
        var totalStock = parseInt($(this).data('total-stock'));
        var availableStock = $(this).data('available-stock');

        if (!isNaN(availableStock) && requestedQuantity > totalStock) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Quantity',
                text: 'Requested quantity exceeds the available stock.',
            });
            $(this).val($(this).data('initial-quantity'));
        }
    });

    $('#saveMaterialChanges').click(function() {

        $(this).prop('disabled', true);

        var formData = new FormData($('#materialDataForm')[0]);

        var advanceCash = $('#typeNumber').val();

        formData.append('advance_cash', advanceCash);

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
                    text: response.message
                });
                console.log(response.test);
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
        console.log(requestId); // Log the ID when the reject button is clicked

        // Show the reject reason modal
        $('#rejectReasonModal').modal('show');
        $('#materialModal').modal('hide');

        // Handle rejection when confirm button is clicked
        $('#confirmRejectButton').click(function() {

            $(this).prop('disabled', true);

            var rejectReason = $('#rejectReasonTextarea').val();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            // Make AJAX request to reject the ticket with reason
            $.ajax({
                url: '/ticket/' + requestId + '/reject',
                method: 'PUT',
                data: { reason: rejectReason }, // Include reject reason in the request data
                success: function(response) {
                    Swal.fire("Success", response.message, "success").then(function(){
                        location.reload();
                    });
                    // Optionally, close the modal or update the UI after success
                    $('#materialModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire("Error", "Failed to reject request", "error");
                }
            });
        });
    });

    $('#approveButton').click(function() {

        $(this).prop('disabled', true);

        var requestId = $(this).data('request-id');
        console.log(requestId); // Log the ID when the approve button is clicked
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $.ajax({
            url: '/ticket/' + requestId + '/approve',
            method: 'PUT',
            success: function(response) {
                Swal.fire("Success", response.message, "success").then(function(){
                        location.reload();
                    });
                // Optionally, close the modal or update the UI after success
                $('#materialModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire("Error", "Failed to approve request", "error");
            }
        });
    });



</script>

@endsection
