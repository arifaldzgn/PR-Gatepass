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
        <div class="row m-5">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">PR Log Histories</h4>
                    <p class="card-description"> All users activities on<code> PR Request</code></p>
                    <div class="table-responsive">
                      <table class="table table-striped" id="example" >
                        <thead>
                          <tr>
                            <th>Username</th>
                            <th>PR Number</th>
                            <th>Action</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                              <td>{{ $log->user->name }}</td>
                              @if ($log->prTicket)
                              <td>{{ $log->prTicket->ticketCode }}</td>
                              @else
                              <td>PR has deleted</td>
                              @endif
                              @if($log->action === 'created')
                              <td><label class="badge badge-success">Created</label></td>
                              @elseif( $log->action === 'deleted' )
                              <td><label class="badge badge-danger">Deleted</label></td>
                              @else
                              <td><label class="badge badge-warning">Updated</label></td>
                              @endif
                              <td>{{ $log->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="row m-5">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Part Histories</h4>
                    <p class="card-description"> All users activities on<code> PartList</code></p>
                    <div class="table-responsive">
                      <table class="table table-striped" id="example2" >
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Source</th>
                            <th>Operations</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($partLogs as $part)
                            <tr>
                              <td>{{ $part->partList->part_name }}</td>
                              <td>{{ $part->quantity }}</td>
                              <td>{{ $part->source }}</td>
                              @if($part->operations == 'plus')
                              <td><label class="badge badge-success">Added</label></td>
                              @else
                              <td><label class="badge badge-danger">Reduced</label></td>
                              @endif
                              <td>{{ $part->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>


    </main>




<script>

</script>


<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection
