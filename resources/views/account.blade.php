@extends('layouts.main')
@extends('layouts.partials.dashboard_modals')

@section('container')

<main class="p-4 min-vh-200">

    <section class="row">
        <div class="col-md-6 col-lg-4">
            <article class="p-4 rounded shadow-sm border-left-card mb-4">
                <a href="#" class="d-flex align-items-center">
                    <span class="bi bi-person-plus h4 text-success"></span>
                    <h5 class="ml-3 text-success" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Create New Account</h5>
                </a>
            </article>
        </div>
    </section>

    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Badge</th>
                    <th>Department</th>
                    <th>PIC Name</th>
                    <th>Role</th>
                    <th class="t-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->badge_no }}</td>
                        <td>{{ $d->deptList->dept_name }}</td>
                        <td>{{ $d->deptList->pic_name }}</td>
                        @if ($d->role === 'admin')
                        <td>
                            <span class="badge badge-pill badge-danger">{{ $d->role }}</span>
                        </td>
                        @elseif ($d->role === 'pic')
                        <td>
                            <span class="badge badge-pill badge-success">{{ $d->role }}</span>
                        </td>
                        @else
                        <td>
                            <span class="badge badge-pill badge-secondary">{{ $d->role }}</span>
                        </td>
                        @endif
                        <td>
                            <button class="updateBtn btn btn-primary" data-request-id="{{ $d->id }}" onclick="console.log('{{ $d->id }}')"><i class="bi bi-pencil-square"></i></button>
                            @if ($d->role !== 'admin')
                            <button class="btn btn-danger delete-btn" data-user-id="{{ $d->id }}"><i class="bi bi-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>


<script>
    // Save Changes / Update Button
    $('#submitRequest').click(function() {
        console.log('saveMaterial');
        var formData = $('#createAccountForm').serialize();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/account',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'New account successfully added'
                }).then(function(){
                        location.reload();
                    });;;
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add new account'
                });
            }
        });
    });

     // Delete Confirmation Modal & Button
     document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('deleteModal');

        var deleteButtons = document.querySelectorAll('.delete-btn');

        var userId;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                userId = button.getAttribute('data-user-id');
                modal.style.display = 'block';
            });
        });

         // Delete
        var confirmDeleteBtn = document.getElementById('confirmDelete');

        confirmDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            deleteItem(userId);
        });

        // Cancel
        var cancelDeleteBtn = document.getElementById('cancelDelete');

        cancelDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        function deleteItem(userId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                url: '/account/' + userId,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Success', 'User deleted', 'success').then(function(){
                        location.reload();
                    });;;
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'User delete failed', 'error');
                }
            });
        }
    });

    $(document).ready(function() {
    // Handle click event on the button
    $('.updateBtn').click(function() {
        var requestId = $(this).data('request-id');

        // Fetch data using AJAX
        $.ajax({
            url: '/get-user-details/' + requestId, // Assuming this route exists in your Laravel routes
            type: 'GET',
            success: function(response) {
                // Populate modal form fields with fetched data
                $('#name').val(response.user.name);
                $('#email').val(response.user.email);
                $('#badge_no').val(response.user.badge_no);
                $('#role').val(response.user.role);
                $('#hod').val(response.hod);
                var select = document.getElementById("dept");
                response.dept_list.forEach(function(dept) {
                    var option = document.createElement("option");
                    option.text = dept.dept_name;
                    option.value = dept.id;
                    if (dept.id === response.user.deptList_id) {
                        option.selected = true; // Set this option as selected if it matches the default department ID
                    }
                    select.add(option);
                });
                document.addEventListener('DOMContentLoaded', function () {
                    const roleSelect = document.getElementById('role');
                    const userRole = response.user.role;
                    console.log(response.user.role);
                    // Set the value of the select element to match the user's role
                    if (roleSelect) {
                        roleSelect.value = userRole;
                    }
                });

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
            url: '/update-user-details/', // Assuming this route exists in your Laravel routes
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
                    title: 'Error...',
                    text: 'Something went wrong!',
                });
            }
        });
    });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection
