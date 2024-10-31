@extends('layouts.main')
@extends('layouts.partials.pr_modals')

@section('container')

<style>
    .image-container {
    width: 100%;
    height: 400px; /* Set a fixed height */
    overflow: hidden; /* Hide overflow */
    display: flex; /* Center the image */
    justify-content: center;
    align-items: center;
}

.image-container img {
    height: auto;
    width: auto; /* Maintain aspect ratio */
    height: 100%; /* Cover the container height */
    object-fit: cover; /* Crop the image to fill the container */
}
</style>
<main class="p-4 min-vh-200">

    <form id="gatePassForm" action="{{ route('gatepassUpdate') }}" method="POST">
        @csrf
        <div class="container">

            <a class="btn btn-outline-secondary mb-4" href="{{ URL::previous() }}" role="button"><i class="bi bi-arrow-return-left"></i> Back</a>
            @if (session('alert-success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('alert-success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> There were some problems with your submission. Please check the form below.
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title text-muted">GatePass No. {{ $dataT->ticket }}</h4>
                    <h6 class="small card-title text-muted">Request status :
                        @if( $dataT->status ===  'Approved' )
                            <span class="badge badge-pill badge-success">Approved</span>
                        @elseif( $dataT->status ===  'Rejected')
                            <span class="badge badge-pill badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-pill badge-warning">Pending</span>
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mt-4 mb-4">
                        <label class="form-label" for="company_name">Company Name :</label>
                        <input  @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control" id="company_name" name="company_name" value="{{ $dataT->company_name }}">
                        <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="hidden" class="form-control" id="company_name" name="ticket_id" value="{{ $dataT->id }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="company_address">Company Address :</label>
                        <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control" id="company_address" name="company_address" value="{{ $dataT->company_address }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="company_employee">Company Employee Name :</label>
                        <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control" id="company_employee" name="company_employee" value="{{ $dataT->company_employee }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="company_vehno">Company Vehicle Number :</label>
                        <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control" id="company_vehno" name="company_vehno" value="{{ $dataT->company_vehno }}">
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-label" for="user_id">Requested By : <span class="badge badge-pill badge-primary">{{ App\Models\User::find($dataT->user_id)->name }}</span></label>
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control" id="user_id" name="user_id" value="{{ App\Models\User::find($dataT->user_id)->name }}" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label" for="checked_by">Checked By :</label>
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control " id="checked_by" name="checked_by" value="{{ App\Models\User::find($dataT->user_id)->checked_by }}" readonly>
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label class="form-label" for="approved_by">Approved By :</label>
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" class="form-control" id="approved_by" name="approved_by" value="{{ App\Models\User::find($dataT->user_id)->approved_by }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @foreach ($dataR as $dR)
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="text-muted">Item No. {{$loop->iteration}}</h4>
                    <h6 class="small card-title text-muted">Akan membawa keluar barang-barang di bawah ini dari lingkungan perusahaan</h6>
                </div>
                <div class="card-body">
                    <div class="custom-control custom-radio mt-2">
                        <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="radio" class="custom-control-input" id="customControlValidationTrue_{{ $loop->index }}" name="pr_request[{{$loop->iteration}}][company_item]"
                               value="true" @if($dR->company_item == 'true') checked @endif required>
                        <label class="custom-control-label" for="customControlValidationTrue_{{ $loop->index }}">
                            Company item
                        </label>
                    </div>
                    <div class="custom-control custom-radio mb-2">
                        <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="radio" class="custom-control-input" id="customControlValidationFalse_{{ $loop->index }}" name="pr_request[{{$loop->iteration}}][company_item]"
                               value="false" @if($dR->company_item == 'false') checked @endif required>
                        <label class="custom-control-label" for="customControlValidationFalse_{{ $loop->index }}">
                            Non-company item
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="Quantity[{{$loop->iteration}}]">Quantity:</label>
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="number" id="Quantity[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][quantity]" value="{{$dR->quantity}}" />
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="hidden" class="form-control" name="pr_request[{{$loop->iteration}}][id]" value="{{$dR->id}}" />
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="hidden" class="form-control" name="pr_request[{{$loop->iteration}}][image_url]" value="{{$dR->image_url}}" />
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="Unit[{{$loop->iteration}}]">Unit</label>
                            <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="text" id="Unit[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][unit]" value="{{$dR->unit}}" />
                        </div>
                    </div>
                    <div class="mt-4 mb-3">
                        <label class="form-label" for="Desc[{{$loop->iteration}}]">Description / Uraian:</label>
                        <textarea @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif width="200px" id="Desc[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][desc]">{{$dR->desc}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Remakrs / Keterangan:</label>
                        <textarea @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif width="200px" id="Remakrs[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][remark]">{{$dR->remark}}</textarea>
                    </div>
                    <br>
                    @if($dataT->checked_user_id !== null)
                    <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Image captured by : <span class="text-primary">{{ App\Models\User::find($dataT->user_id)->name }}</span></label>
                    <div class="row">
                        @php
                            $imageUrls = json_decode($dR->image_url, true);
                        @endphp
                        @foreach ($imageUrls as $img)
                            <div class="col-md-4    ">
                                <img src="{{ asset($img) }}" alt="Image" class="img-thumbnail">
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Verification by : <span class="text-primary">{{ App\Models\User::find($dataT->checked_user_id)->name }}</span></label>
                    <div class="row">
                        @php
                            $imageUrls = json_decode($dR->image_url, true);
                        @endphp
                        @foreach ($imageUrls as $img)
                            <div class="col-md-4    ">
                                <img src="{{ asset($img) }}" alt="Image" class="img-thumbnail">
                            </div>
                        @endforeach
                    </div>
                    @else
                    <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Image captured by : <span class="text-primary">{{ App\Models\User::find($dataT->user_id)->name }}</span></label>
                    <div class="row">
                        @php
                            $imageUrls = json_decode($dR->image_url, true);
                        @endphp
                        @foreach ($imageUrls as $img)
                            <div class="col-md-4">
                                <div class="image-container text-center">
                                    <a href="{{ asset($img) }}" target="_blank">
                                        <img src="{{ asset($img) }}" alt="Image" class="img-fluid img-thumbnail">
                                    </a>
                                </div>
                                <small class="text-muted text-center d-block mt-2">Click to view full image</small>
                            </div>
                        @endforeach

                    </div>

                    <div class="mb-3 mt-4">
                        <label class="form-label">Additional Note:</label>
                        <textarea class="form-control" value="123" placeholder="Add notes based on the related items above (Condition, shape, quantity, etc.)" name="pr_request[{{$loop->iteration}}][note]">{{$dR->note}}</textarea>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach

            <div class="mt-4 card text-center">
                <div class="m-3 row justify-content-center">
                    @if(auth()->user()->role === 'admin' or auth()->user()->role === 'hod' or auth()->user()->role === 'security')
                        @if($dataT->status == 'reject')
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-warning btn-block" type="submit" onclick="setAction('reject')">Reject</button>
                        </div>
                        @endif
                        @if(auth()->user()->role === 'security' && $dataT->status === 'Approved')
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-success btn-block" type="submit" onclick="setAction('security_approve')">Approve S</button>
                        </div>
                        @endif
                        @if(auth()->user()->role === 'hod2' or auth()->user()->role === 'admin' && $dataT->approved_user_id === null)
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-success btn-block" type="submit" onclick="setAction('manager_approve')">Approve M</button>
                        </div>
                        @endif
                    @endif
                    @if($dataT->user_id !== auth()->user()->id)
                        <div class="col-6 col-md-2 mb-2">
                            <a class="btn btn-primary btn-block" href="{{ URL::previous() }}">Back</a>
                        </div>
                    @else
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-primary btn-block" type="submit" onclick="setAction('save')">Save</button>
                        </div>
                    @endif
                </div>
                <!-- Hidden input to store the action -->
                <input @if($userRole === 'admin' or $userRole === 'hod2') @else @if($dataT->user_id !== auth()->user()->id) readonly @endif @endif type="hidden" id="actionInput" name="action" value="">
            </div>
        </div>
    </form>



</main>

@endsection

@section('script')
<script>
    function setAction(action) {
        document.getElementById('actionInput').value = action;
        document.getElementById('gatePassForm').submit(); // Submit the form
    }
</script>
@endsection
