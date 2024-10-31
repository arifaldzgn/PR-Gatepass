@extends('layouts.main')
@extends('layouts.partials.partlist_modals')

@section('container')

<main class="p-4 min-vh-200">

    <section class="row">
        <div class="col-md-6 col-lg-4">
            <article class="p-4 rounded shadow-sm border-left-card mb-4">
                <a href="#" class="d-flex align-items-center">
                    <span class="bi bi-list-task h4 text-success"></span>
                    <h5 class="ml-3 text-success" data-bs-target="#createPartList" data-bs-toggle="modal">Create New PartList</h5>
                </a>
            </article>
        </div>
    </section>

    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4 p-4">
        <h4 class="card-title">Stock Part</h4>
        <p class="card-description text-muted"><small> All part with changeable<code> Stock </code></p></small>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Part Name</th>
                    {{-- <th>Asset Code</th> --}}
                    <th>Category</th>
                    <th>Description</th>
                    <th><center>Stock</center></th>
                    <th>UoM</th>
                    <th><center>Action</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stock as $s)
                <tr>
                    <td>{{ $s->part_name }}</td>
                    {{-- @if ($s->assetCode)
                        <td> {{ $s->assetCode->deptList->dept_code }} - {{ $s->assetCode->asset_code }} </td>
                    @else
                        <td>No Asset Code Available</td>
                    @endif --}}
                    <td>{{ $s->category }}</td>
                    <td>{{ $s->type }}</td>
                    <td><center>{{ $s->PartStock->where('operations', 'plus')->sum('quantity') - $s->PartStock->where('operations', 'minus')->sum('quantity') }}</center></td>
                    <td>{{ $s->UoM }}</td>
                    <td>
                        <center>
                        <button class="updateBtn btn btn-primary" data-request-id="{{ $s->id }}" onclick="console.log('{{ $s->id }}')"><i class="bi bi-pencil-square"></i></button>
                        {{-- <button class="btn btn-danger delete-btn" data-part-id="{{ $s->id }}" onclick="console.log('{{ $s->id }}')"><i class="bi bi-trash"></i></button> --}}
                        @if ($s->role !== 'admin')
                        @endif
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4 p-4">
        <h4 class="card-title">Non-Stock Part</h4>
        <p class="card-description text-muted"><small> All part with un-changeable<code> Stock </code></p></small>
        <table id="example2" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Part Name</th>
                    {{-- <th>Asset Code</th> --}}
                    <th>Category</th>
                    <th>Description</th>
                    <th>UoM</th>
                    <th><center>Action</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nonStock as $nS)
                <tr>
                    <td>{{ $nS->part_name }}</td>
                    {{-- @if ($nS->assetCode)
                        <td> {{ $nS->assetCode->deptList->dept_code }} - {{ $nS->assetCode->asset_code }} </td>
                    @else
                        <td>No Asset Code Available</td>
                    @endif --}}
                    <td>{{ $nS->category }}</td>
                    <td>{{ $nS->type }}</td>
                    <td>{{ $nS->UoM }}</td>
                    <td>
                        <center>
                        <button class="updateBtn btn btn-primary" data-request-id="{{ $nS->id }}" onclick="console.log('{{ $nS->id }}')"><i class="bi bi-pencil-square"></i></button>
                        {{-- <button class="btn btn-danger delete-btn" data-part-id="{{ $nS->id }}" onclick="console.log('{{ $nS->id }}')"><i class="bi bi-trash"></i></button> --}}
                        @if ($nS->role !== 'admin')
                        @endif
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</main>

<script>
    $('#submitRequest').click(function() {
        console.log('saveMaterial');
        var formData = $('#createPartlistForm').serialize();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/partlist',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'New Part successfully added'
                }).then(function(){
                        location.reload();
                    });
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
                    });;;
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to delete the part', 'error');
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const itemTypeSelector = document.getElementById('itemTypeSelector');
        const formFields = document.querySelectorAll('#createPartlistForm input, #createPartlistForm select');
        const stockField = document.getElementById('stockField');
        const uomField = document.getElementById('UoM');
        const submitButton = document.getElementById('submitRequest');

        itemTypeSelector.addEventListener('change', function () {
            if (itemTypeSelector.value === 'stock') {
                stockField.style.display = 'block';
                uomField.style.display = 'none';
                enableFormFields();
            } else if (itemTypeSelector.value === 'non-stock') {
                stockField.style.display = 'none';
                uomField.style.display = 'block';
                enableFormFields();
            } else {
                disableFormFields();
            }

            const noneOption = itemTypeSelector.querySelector('option[value="none"]');
            if (noneOption) {
                noneOption.remove();
            }
        });

        function enableFormFields() {
            formFields.forEach(field => {
                if (field !== itemTypeSelector) {
                    field.disabled = false;
                }
            });
            submitButton.disabled = false;
        }

        function disableFormFields() {
            formFields.forEach(field => {
                if (field !== itemTypeSelector) {
                    field.disabled = true;
                }
            });
            submitButton.disabled = true;
        }

        // Initially disable all fields except the selector
        disableFormFields();
    });

    $(document).ready(function() {
    // Handle click event on the button
    $('.updateBtn').click(function() {
        var requestId = $(this).data('request-id');

        // Fetch data using AJAX
        $.ajax({
            url: '/get-part-details/' + requestId, // Assuming this route exists in your Laravel routes
            type: 'GET',
            success: function(response) {
                // Populate modal form fields with fetched data
                $('#partId').val(response.id);
                $('#partName').val(response.data.part_name);
                $('#category').val(response.data.category);
                $('#description').val(response.data.type);
                $('#stock').val(response.stock);
                $('#part_id').val(response.data.id);
                $('#quantity').attr('min', -response.stock);

                // Show the modal
                $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    });

    // Handle form submission
    $('#editForm').submit(function(event) {
        event.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Submit form using AJAX
        $.ajax({
            url: '/update-part-details', // Assuming this route exists in your Laravel routes
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000, // Auto close after 2 seconds
                    showConfirmButton: false
                }).then(function() {
                    // Optionally close modal or redirect
                    $('#editModal').modal('hide');
                });
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            }
        });
    });
});

</script>


<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection
