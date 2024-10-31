@extends('layouts.main')
@extends('layouts.partials.pr_modals')

@section('container')

<main class="p-4 min-vh-200">

    <div class="col-lg-5">
        <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm ">
            <h2 class="ml-4 text-primary">Rejected PR Ticket</h2>
            <small class="ml-4 form-text text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, itaque.</small>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4 primary">
        <table id="example" class="table table-striped display compact" style="width:100%">
            <thead>
                <tr>
                    <th>Request Date</th>
                    <th>Ticket Code</th>
                    <th>Requestor</th>
                    <th>Status</th>
                    <th class="reason-column">Reason</th>
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
                        @if ($dT->status === 'Pending')
                        <span class="badge badge-pill badge-secondary">{{ $dT->status }}</span>
                        @elseif ($dT->status === 'Rejected')
                        <span class="badge badge-pill badge-danger">{{ $dT->status }}</span>
                        @else
                        <span class="badge badge-pill badge-success">{{ $dT->status }}</span>
                        @endif
                    </td>
                    <td>
                        <small>{{ $dT->reason_reject     }}</small>
                    </td>
                    <td>
                        @if ($dT->status === 'Pending')
                        <center><button class="updateBtn btn btn-primary" data-request-id="{{ $dT->id }}">Update</button></center>
                        @elseif ($dT->status === 'Rejected')
                        <center><button class="updateBtn btn btn-warning" data-request-id="{{ $dT->id }}">Update</button></center>
                        @else
                        <center>-</center>
                        @endif
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

    // Save
    // $('#saveMaterialChanges').click(function() {
    //     // console.log('saveMaterial');
    //     var formData = $('#materialDataForm').serialize();

    //     $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //     }
    //     });

    //     $.ajax({
    //         url: '/updateTicketR',
    //         method: 'POST',
    //         data: formData,
    //         success: function(response) {
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Success',
    //                 text: 'Material data updated successfully'
    //             }).then(function(){
    //                     location.reload();
    //                 });;
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Error',
    //                 text: 'Failed to update material data'
    //             });
    //         }
    //         });
    // });

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

    // Delete
    // Delete Confirmation Modal & Button
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('deleteModal');

        var deleteButtons = document.querySelectorAll('.delete-btn');

        var partId;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                partId = button.getAttribute('data-part-id');
                modal.style.display = 'block';
            });
        });

        // Delete
        var confirmDeleteBtn = document.getElementById('confirmDelete');

        confirmDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            deleteItem(partId);
        });

        // Cancel
        var cancelDeleteBtn = document.getElementById('cancelDelete');

        cancelDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        function deleteItem(partId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });
            $.ajax({
                url: '/partlist/' + partId,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Success', 'Part deleted', 'success').then(function(){
                        location.reload();
                    });;
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to delete the part', 'error');
                }
            });
        }
    });




    // // Create our number formatter.
    // var formatter = new Intl.NumberFormat('id-ID', {
    // style: 'currency',
    // currency: 'IDR',
    // });

    // document.querySelector('#typeNumber').addEventListener('change', (e)=>{
    // if(isNaN(e.target.value)){
    //     e.target.value = ''
    // }else{
    //     e.target.value = formatter.format(e.target.value);
    // }
    // })




jQuery(document).ready(function($) {
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

// Show Details Material Button
$(document).ready(function() {
    $('.updateBtn').click(function() {
        var requestId = $(this).data('request-id');
        $('#approveButton').data('request-id', requestId);
        $('#rejectButton').data('request-id', requestId);

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

        // Create a FormData object from the form
        var formData = new FormData($('#materialDataForm')[0]);

        // Get the advance_cash value
        var advanceCash = $('#typeNumber').val();

        // Append the advance_cash value to the FormData object
        formData.append('advance_cash', advanceCash);

        var formData = $('#materialDataForm').serialize();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/updateTicketR',
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


$('#materialDataForm').on('click', '.close', function() {

    if ($(this).is(':disabled')) {
        return;
    }

    var partId = $(this).data('delete-id');
    var cardToRemove = $(this).closest('.card');

    console.log(partId);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $.ajax({
        url: '/delete-part/' + partId,
        method: 'DELETE',
        success: function(response) {
            cardToRemove.remove();
            console.log('Part deleted successfully');
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


</script>

@endsection
