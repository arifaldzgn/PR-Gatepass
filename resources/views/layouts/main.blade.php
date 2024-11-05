<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  @if (Route::currentRouteName() === 'dashboard')
  <title>Dashboard</title>
  @endif

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <!-- Include jQuery library -->




  {{-- Select --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  {{-- Font --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">


  {{-- Custom CSS --}}
  <link rel="stylesheet" href="/css/style.css">

</head>

@if (Route::currentRouteName() === 'login' or Route::currentRouteName() === 'printTicket')
@else
<body>
<div id="sidebar-overlay" class="overlay w-100 vh-100 position-fixed d-none"></div>
<!-- Sidebar -->
<div class="col-md-3 col-lg-2 px-0 position-fixed h-100 bg-white shadow-sm sidebar" id="sidebar">
  <h3 class="bi bi-app-indicator text-primary d-flex my-4 justify-content-center">@if(session('menu') === 'gatepass') GatePass @else PR Request @endif</h3>
  <div class="list-group rounded-0">

    @if (session('menu') === 'gatepass')
        @include('layouts.partials.gatepass_sidebar')
    @else
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action @if (request()->route()->named('dashboard')) active @endif border-0 d-flex align-items-center">
            <span class="bi bi-border-all"></span>
            <span class="ml-2">Dashboard</span>
        </a>
        @include('layouts.partials.pr_sidebar')
    @endif

<div class="col-md-9 col-lg-10 ml-md-auto px-0 ms-md-auto">
  <!-- Top nav -->
  <nav class="w-100 d-flex px-4 py-2 mb-4 shadow-sm">
    <button class="btn py-0 d-lg-none" id="open-sidebar">
      <span class="bi bi-list text-primary h3"></span>
    </button>
    <div class="dropdown ml-auto">
      <button class="btn py-0 d-flex align-items-center" id="logout-dropdown" data-toggle="dropdown" aria-expanded="false">
        <span class="bi bi-person text-primary h4"></span>
        <span class="bi bi-chevron-down ml-1 mb-2 small"></span>
      </button>
      <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm" aria-labelledby="logout-dropdown">
        <p class="dropdown-item">{{ auth()->user()->name }} | {{ auth()->user()->badge_no }}</p>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">Settings</a>
        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Profile Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Profile Settings Form -->
                <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                    @csrf
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" disabled>
                    </div>
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="name">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                    </div>
                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <!-- Confirm Password Field -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div id="password_confirmation_feedback" class="invalid-feedback"></div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endif

@yield('container')

</body>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Popper.js -->
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script> --}}

<!-- Bootstrap Select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables -->
<script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script defer src="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css"></script>
<script defer src="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css"></script>
<!-- Custom Script -->
<script src="/script/dashboard.js"></script>

<script>
    $(document).ready(function($) {
        $('#password_confirmation').on('keyup', function() {
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();

            if (password !== confirmPassword) {
                $('#password_confirmation').addClass('is-invalid');
                $('#password_confirmation_feedback').text('Passwords do not match.');
            } else {
                $('#password_confirmation').removeClass('is-invalid');
                $('#password_confirmation_feedback').text('');
            }
        });

        $('#profileForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("profile.update") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Check the response message
                    if (response.message.includes('password')) {
                        swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Redirect or reload the page if necessary
                            window.location.reload(); // Example: reload the page
                        });
                    }
                },
                error: function(xhr, status, error) {
                    swal.fire({
                        title: 'Error',
                        text: 'There was an error updating the profile.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

@yield('script')


</html>

