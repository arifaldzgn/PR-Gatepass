@extends('layouts.main')
@extends('layouts.partials.pr_modals')

@section('container')

<main class="p-4 min-vh-200">

    <div class="col-lg-5">
        <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm ">
            <h2 class="ml-4 text-primary">Pending GatePass Request</h2>
            <small class="ml-4 form-text text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, itaque.</small>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
        <table id="example" class="table table-striped display compact" style="width:100%">
            <thead>
                <tr>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Requested by</th>
                    <th>Office no</th>
                    <th>Company name</th>
                    <th>Company address</th>
                    <th>Company employee</th>
                    <th><center>Action</center></th>
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
                        <span class="badge badge-pill badge-success">{{ $d->status }}</span>
                        @endif
                    </td>
                    <td>{{ App\Models\User::find($d->user_id)->name }}</td>
                    <td>{{ $d->ticket }}</td>
                    <td>{{ $d->company_name }}</td>
                    <td>{{ $d->company_address }}</td>
                    <td>{{ $d->company_employee }}</td>
                    <td>
                        <center>
                            @if ($d->status === 'Approved')
                            <a class="delete-btn btn btn-success" data-item-id="{{ $d->id }}"><i class="bi bi-printer"></i></a>
                            @else
                            <a class="updateBtn btn btn-warning" data-request-id="{{ $d->id }}" href="/edit_gatepass/{{ $d->id }}"><i class="bi bi-pencil-square"></i></a>
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
