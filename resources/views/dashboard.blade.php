@extends('layouts.main')


@section('container')
    @if (session('success'))
    <script>
        Swal.fire('Success', '{{ session('success') }}', 'success');
    </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire('Error', '{{ session('error') }}', 'error');
        </script>
    @endif

  <!-- Main Content -->
  <main class="p-4 min-vh-200">

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
                        <th>Request Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="t-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </main>




<script>

</script>


<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection
