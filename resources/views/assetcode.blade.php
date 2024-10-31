@extends('layouts.main')
@extends('layouts.partials.assetcode_modals')

@section('container')

<main class="p-4 min-vh-200">

    <section class="row">
        <div class="col-md-6 col-lg-4">
            <article class="p-4 rounded shadow-sm border-left-card mb-4">
                <a href="#" class="d-flex align-items-center">
                    <span class="bi bi-upc-scan h4 text-success"></span>
                    <h5 class="ml-3 text-success" data-bs-target="#createAssetCode" data-bs-toggle="modal">Create New Asset Code</h5>
                </a>
            </article>
        </div>
    </section>

    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Asset Code</th>
                    <th>Dept Code</th>
                    <th>Dept Name</th>
                    <th>PIC Name</th>
                    <th class="t-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $d->asset_code }}</td>
                    <td>{{ $d->dept_code }} </td>
                    <td>{{ $d->deptList->dept_name }} Department </td>
                    <td>{{ $d->deptList->pic_name }} </td>
                    <td>
                        <button class="updateBtn btn btn-primary" data-request-id="{{ $d->id }}" onclick="console.log('{{ $d->id }}')"><i class="bi bi-pencil-square"></i></button>
                        @if ($d->role !== 'admin')
                        <button class="btn btn-danger delete-btn" data-asset-id="{{ $d->id }}"><i class="bi bi-trash"></i></button>
                        @endif
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
        var formData = $('#createAssetCodeForm').serialize();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/assetcode',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'New asset code successfully added'
                }).then(function(){
                        location.reload();
                    });;
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add acces code'
                });
            }
            });
    });

      // Delete Confirmation Modal & Button
      document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('deleteModal');

        var deleteButtons = document.querySelectorAll('.delete-btn');

        var assetId;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                assetId = button.getAttribute('data-asset-id');
                modal.style.display = 'block';
            });
        });

        // Delete
        var confirmDeleteBtn = document.getElementById('confirmDelete');

        confirmDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            deleteItem(assetId);
        });

        // Cancel
        var cancelDeleteBtn = document.getElementById('cancelDelete');

        cancelDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        function deleteItem(assetId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });
            $.ajax({
                url: '/assetcode/' + assetId,
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
</script>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection
