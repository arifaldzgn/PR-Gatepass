@extends('layouts.main')
@extends('layouts.partials.pr_modals')

@section('container')

<main class="p-4 min-vh-200">

    <div class="col-lg-6">
        <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm ">
            <h2 class="ml-4 text-primary">Approved GatePass Request</h2>
            {{-- <a class="ml-4 form-text text-muted">Note for status : </a> --}}
            {{-- <span class="ml-4 badge badge-pill badge-success">Granted by security :</span> <small class="text-muted">Requests has been verified by security with the latest image of the items</small> --}}
            {{-- <span class="ml-4 badge badge-pill badge-success">Granted by security :</span> <small class="text-muted">Requests has been verified by security with the latest image of the items</small> --}}

        </div>
    </div>
    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped display compact" style="width:100%">
            <thead>
                <tr>
                    <th>Created at</th>
                    <th><center>Status</center></th>
                    <th>Requested by</th>
                    <th>Office no</th>
                    <th>Company name</th>
                    <th>Company address</th>
                    <th>Company employee</th>
                    <th width="8%"><center>Action</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $d->created_at }}</td>
                    <td>
                        @if ($d->status === 'Pending' or $d->status === 'Revised')
                        <span class="badge badge-pill badge-secondary">{{ $d->status }}</span>
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
                    <td>

                            @if ($d->status === 'Approved')
                                @if ($d->approved_user_id !== null && $d->checked_user_id !== null)
                                    <center><a class="btn btn-success" data-item-id="{{ $d->id }}" href="/print_gatepass/{{$d->ticket}}"><i class="bi bi-printer"></i></a></center>
                                @elseif($d->approved_user_id !== null)
                                    <center><a class="btn btn-success" data-item-id="{{ $d->id }}" href="/print_gatepass/{{$d->ticket}}" target="_blank"><i class="bi bi-printer"></i></a></center>
                                    @if (auth()->user()->role === 'security')
                                        <center><a class="btn btn-primary" data-item-id="{{ $d->id }}" href="/verif_gatepass/{{$d->ticket}}"><i class="bi bi-file-earmark-check"></i></a></center>
                                    @endif
                                @endif
                            @else
                                -
                            @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</main>

@endsection
