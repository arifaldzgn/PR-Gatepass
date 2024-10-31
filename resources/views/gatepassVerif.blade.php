@extends('layouts.main')
@extends('layouts.partials.pr_modals')

@section('container')

<main class="p-4 min-vh-200">

    <form id="gatePassForm" action="{{ route('gatepassUpdate2') }}" method="POST" enctype="multipart/form-data">
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
                            <span class="badge badge-pill badge-primary">Approved, need checked by security</span>
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
                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $dataT->company_name }}" readonly>
                        <input type="hidden" class="form-control" id="company_name" name="ticket_id" value="{{ $dataT->id }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="company_address">Company Address :</label>
                        <input type="text" class="form-control" id="company_address" name="company_address" value="{{ $dataT->company_address }}" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="company_employee">Company Employee Name :</label>
                        <input type="text" class="form-control" id="company_employee" name="company_employee" value="{{ $dataT->company_employee }}" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="company_vehno">Company Vehicle Number :</label>
                        <input type="text" class="form-control" id="company_vehno" name="company_vehno" value="{{ $dataT->company_vehno }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-label" for="user_id">Requested By : <span class="badge badge-pill badge-primary">{{ App\Models\User::find($dataT->user_id)->name }}</span></label>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="{{ App\Models\User::find($dataT->user_id)->name }}" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label" for="checked_by">Checked By :</label>
                            <input type="text" class="form-control " id="checked_by" name="checked_by" value="{{ App\Models\User::find($dataT->user_id)->checked_by }}" readonly>
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label class="form-label" for="approved_by">Approved By : <span class="badge badge-pill badge-warning">{{ App\Models\User::find($dataT->approved_user_id)->name }}</span></label>
                            <input type="text" class="form-control" id="approved_by" name="approved_by" value="{{ App\Models\User::find($dataT->approved_user_id)->name }}" readonly>
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
                        <input type="radio" class="custom-control-input" id="customControlValidationTrue_{{ $loop->index }}" name="pr_request[{{$loop->iteration}}][company_item]"
                               value="true" @if($dR->company_item == 'true') disabled checked @endif disabled required>
                        <label class="custom-control-label" for="customControlValidationTrue_{{ $loop->index }}">
                            Company item
                        </label>
                    </div>
                    <div class="custom-control custom-radio mb-2">
                        <input type="radio" class="custom-control-input" id="customControlValidationFalse_{{ $loop->index }}" name="pr_request[{{$loop->iteration}}][company_item]"
                               value="false" @if($dR->company_item == 'false') disabled checked @endif disabled required>
                        <label class="custom-control-label" for="customControlValidationFalse_{{ $loop->index }}">
                            Non-company item
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="Quantity[{{$loop->iteration}}]">Quantity</label>
                            <input type="number" id="Quantity[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][quantity]" value="{{$dR->quantity}}" readonly/>
                            <input type="hidden" class="form-control" name="pr_request[{{$loop->iteration}}][id]" value="{{$dR->id}}" />
                            <input type="hidden" class="form-control" name="pr_request[{{$loop->iteration}}][image_url]" value="{{$dR->image_url}}" />
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="Unit[{{$loop->iteration}}]">Unit</label>
                            <input type="text" id="Unit[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][unit]" value="{{$dR->unit}}" readonly />
                        </div>
                    </div>
                    <div class="mt-4 mb-3">
                        <label class="form-label" for="Desc[{{$loop->iteration}}]">Description / Uraian</label>
                        <textarea width="200px" id="Desc[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][desc]" readonly>{{$dR->desc}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Remakrs / Keterangan</label>
                        <textarea width="200px" id="Remakrs[{{$loop->iteration}}]" class="form-control" name="pr_request[{{$loop->iteration}}][remark]" readonly>{{$dR->remark}}</textarea>
                    </div>
                    <br>
                     {{-- Image Row 1 --}}
                     <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Image captured/prepared by : <span class="text-primary">{{ App\Models\User::find($dataT->user_id)->name }}</span></label>
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
                     {{-- End Of Image Row 1 --}}

                     @if($dR->checked_image_url === null)
                        {{-- Image Row --}}
                        <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Image checked by: <span class="text-primary"></span></label>
                        <div class="mb-3 photoRow" id="photoRow{{$loop->iteration}}">

                            <div class="mb-3">
                                <label for="images[{{$loop->iteration}}]">Upload image for this item</label>
                                <div id="photoInputs-{{$loop->iteration}}">
                                    <input type="file" class="form-control-file image-input" name="pr_request[{{$loop->iteration}}][checked_image_url][]" accept="image/*" data-count="{{$loop->iteration}}" onchange="previewImage(this);">
                                </div>
                                <button type="button" class="btn btn-sm btn-primary mt-2 add-photo" data-ticket="{{$loop->iteration}}">Add Another Photo</button>
                            </div>
                        </div>
                        {{-- End Of Image Row --}}
                    @else
                        <label class="form-label" for="Remakrs[{{$loop->iteration}}]">Image checked by: <span class="text-primary">{{App\Models\User::find($dR->gatePassTicket->checked_user_id)->name}}</span></label>
                        <div class="row">
                            @php
                                $imageUrls = json_decode($dR->checked_image_url, true);
                            @endphp
                            @foreach ($imageUrls as $img)
                                <div class="col-md-4">
                                    <img src="{{ asset($img) }}" alt="Image" class="img-thumbnail">
                                </div>
                            @endforeach
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

                        {{-- Security --}}
                        {{-- @if(auth()->user()->role === 'security' && $dataT->status === 'Approved')
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-success btn-block" type="submit" onclick="setAction('security_approve')">Approve S</button>
                        </div>
                        @endif --}}
                        {{-- Security --}}

                        @if(auth()->user()->role === 'hod2' or auth()->user()->role === 'admin' && $dataT->approved_user_id === null)
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-success btn-block" type="submit" onclick="setAction('manager_approve')">Approve M</button>
                        </div>
                        @endif
                    @endif
                    <div class="col-6 col-md-4 mb-2">
                        @if($dataT->checked_user_id === null)
                        <button class="btn btn-success btn-block" type="submit" onclick="setAction('save')">Check</button>
                        @else
                        <a href="{{ route('gatepassApproved') }}" class="btn btn-primary btn-block" >Back</a>
                        @endif
                    </div>
                </div>
                <!-- Hidden input to store the action -->
                <input type="hidden" id="actionInput" name="action" value="">
            </div>
        </div>
    </form>



</main>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Initialize preview for existing file inputs
        $('.image-input').each(function() {
            if (this.files && this.files[0]) {
                previewImage(this);
            }
        });

        // Add another photo input within each ticket section
        $('.add-photo').click(function() {
            var ticketNumber = $(this).data('ticket');
            var photoRow = $('#photoRow' + ticketNumber);

            // Count existing inputs to set the data-count correctly
            var count = photoRow.find('.photo-input-wrapper').length + 1;

            var newInput = $('<div class="photo-input-wrapper">' +
                                '<input type="file" class="form-control-file image-input" name="pr_request[' + ticketNumber + '][checked_image_url][]" accept="image/*" data-count="' + count + '" onchange="previewImage(this)">' +
                                '<img src="" class="preview-image" style="display: none;">' +
                            '</div>');

            // Append new input after the last input in photoRow
            photoRow.append(newInput);
        });

        // Preview image when selected
        window.previewImage = function(input) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var previewImage = $(input).next('.preview-image');
                previewImage.attr('src', e.target.result).show();
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        };
    });
</script>


@endsection
