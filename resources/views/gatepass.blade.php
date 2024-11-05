@extends('layouts.main')
@extends('layouts.partials.gatepass_modal')

@section('container')

  <!-- Main Content -->
  <main class="p-4 min-vh-200">

    <section class="row">
        <div class="col-md-6 col-lg-4">
            <article class="p-4 rounded shadow-sm border-left-card mb-4">
                <a href="#" class="d-flex align-items-center">
                    <span class="bi bi-list-task h4 text-success"></span>
                    <h5 class="ml-3 text-success" data-toggle="modal" data-target="#createPr">New GatePass Request</h5>
                </a>
            </article>
        </div>
    </section>

        @if(request()->route()->named('dashboard'))
        <div class="jumbotron jumbotron-fluid rounded bg-white border-0 shadow-sm border-left px-4">
            <div class="container">
                <h1 class="display-4 mb-2 text-primary">Welcome</h1>
                <p class="lead text-muted">{{ auth()->user()->name }} | {{ auth()->user()->role }} | Badge ID. {{ auth()->user()->badge_no }}</p>
            </div>
        </div>
        @endif

    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Created at</th>
                        <th width=""><center>Status</center></th>
                        <th>Requested by</th>
                        <th>Office no</th>
                        <th>Company name</th>
                        <th>Company address</th>
                        <th>Company employee</th>
                        <th>Company vehicle number</th>

                    </tr>
                </thead>
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
                        <td>{{ $d->company_vehno }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </main>

@section('script')
<script>


    // $('#submitRequest').click(function() {
    //     var formData = $('#createPrForm').serialize();
    //     event.preventDefault();

    //     // Log form data just before submission
    //     console.log('Form Data:', formData);

    //     $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //     }
    //     });

    //     $.ajax({
    //         url: '/gatepass',
    //         method: 'POST',
    //         data: formData,
    //         success: function(response) {
    //             Swal.fire('Success', response.message, 'success').then(function(){
    //                 location.reload();
    //             });;
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire('Error', xhr.responseJSON.error, 'error');
    //         }
    //     });
    // });

    jQuery(document).ready(function($) {

        $('#submitRequest').click(function() {
            var formData = new FormData($('#createPrForm')[0]);

            $.ajax({
                url: "{{ route('create_gatepass') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
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

        // Function to handle file input change
        function readURL(input, count) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(`#photoPreviews-${count}`).append(`<img src="${e.target.result}" alt="your image" class="preview-image" style="max-width: 180px; margin: 10px;" />`);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Event handler for adding new item
        $("#addItem").click(function() {
            if (arrayCount <= 5) {
                var newItem = `
                <div class="card card-body border border-primary">
                    <div class="mb-3">
                        <label class="form-label" for="Quantity[${arrayCount}]">Quantity</label>
                        <input type="number" id="Quantity[${arrayCount}]" class="form-control" name="pr_request[${arrayCount}][quantity]" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="unit[${arrayCount}]">Unit</label>
                        <input type="text" id="unit[${arrayCount}]" class="form-control" name="pr_request[${arrayCount}][unit]" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="desc[${arrayCount}]">Description</label>
                        <input type="text" id="desc[${arrayCount}]" class="form-control" name="pr_request[${arrayCount}][desc]" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="remark[${arrayCount}]">Remark</label>
                        <input type="text" id="remark[${arrayCount}]" class="form-control" name="pr_request[${arrayCount}][remark]" />
                    </div>
                        <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="customControlValidationTrue[${arrayCount}]" name="pr_request[${arrayCount}][company_item]" value="true" required>
                        <label class="custom-control-label" for="customControlValidationTrue[${arrayCount}]">Company item</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="customControlValidationFalse[${arrayCount}]" name="pr_request[${arrayCount}][company_item]" value="false" required>
                        <label class="custom-control-label" for="customControlValidationFalse[${arrayCount}]">Non-company item</label>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="images[${arrayCount}]">Upload image for this item</label>
                        <div id="photoInputs-${arrayCount}">
                            <input type="file" class="form-control-file image-input" name="pr_request[${arrayCount}][image_url][]" accept="image/*" data-count="${arrayCount}" onchange="readURL(this, ${arrayCount});">
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2 add-photo" data-count="${arrayCount}">Add Another Photo</button>
                    </div>
                    <div class="mb-3">
                        <div id="photoPreviews-${arrayCount}">
                        </div>
                    </div>
                </div>
                <br>
            `;

            $("#prRequestForm").append(newItem);
            arrayCount++;
            itemCount++;

            $('#submitRequest').prop('disabled', false);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Maximum is 5',
                    text: 'Maximum items have been reached, Failed to add new request.'
                });
            }
        });

        // Event handler for adding more photos dynamically
        $(document).on('click', '.add-photo', function() {
            var count = $(this).data('count');
            var newInput = `
                <input type="file" class="form-control-file image-input" name="pr_request[${count}][image_url][]" accept="image/*" data-count="${count}" onchange="readURL(this, ${count});">
            `;
            $(`#photoInputs-${count}`).append(newInput);
        });

        // Bind change event for file inputs dynamically
        $(document).on('change', '.image-input', function() {
            var count = $(this).data('count');
            readURL(this, count);
        });

        // Show loading popup on form submission
        $('#prRequestForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Show loading popup
            Swal.fire({
                title: 'Uploading...',
                text: 'Please wait while your request is being processed.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Use FormData to submit the form via AJAX
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close(); // Close the loading popup

                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Your request has been submitted.'
                    });

                    // Optionally, you can reset the form or redirect the user
                    $('#prRequestForm')[0].reset();
                },
                error: function(response) {
                    Swal.close(); // Close the loading popup

                    // Show error notification
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while submitting your request. Please try again.'
                    });
                }
            });
        });
    });



</script>
@endsection

@endsection
