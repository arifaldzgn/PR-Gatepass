<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GATE PASS OFFICE : {{$dataT->ticket}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/_gatepass.css " media="all" />

  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="/images/Etowa.png">
      </div>
      <div>
        <button class="btn btn-secondary no-print" onclick="window.print()">Print this page</button>
    </div>
    <div class="mt-3 mb-3">
        <div id="project">
            <div>
                <span>Requestor</span>
                <b>{{ App\Models\User::find($dataT->user_id)->name }}</b>
            </div>
            <div>
                @if($dataT->status === 'Approved')
                    <span>Status :</span>
                    <b class="badge rounded-pill text-bg-success">Approved</b>
                @else
                    <span>Status</span>
                    <b class="badge rounded-pill text-bg-warning">Pending / Waiting for approval</b>
                @endif
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
      <h2>GATEPASS NO. {{ $dataT->ticket }}</h2>
      <div id="company" class="clearfix">
        <div>PT. ETOWA PACKAGING INDONESIA</div>
        <div>Factory Type B3 LOT 6-7 PANBIL Industrial Estate,<br /> Jalan Ahmad Yani, Muka Kuning, BATAM 29433</div>
        <div>Phone: +62 778 371111</div>
        <div>Fax: +62 778 371188</div>
        {{-- <div><a href="mailto:company@example.com">company@example.com</a></div> --}}
      </div>
      <div id="project">
        <div>
            <span>NAME</span>
            <b>{{ $dataT->company_name }}</b>
        </div>
        <div>
            <span>ADDRESS</span>
            <b>{{ $dataT->company_address }}</b>
        </div>
        <div>
            <span>VEH. NO</span>
            <b>{{ $dataT->company_vehno }}</b>
        </div>
        <div>
            <span>DATE</span>
            <b>{{ $dataT->created_at }}</b>
        </div>
      </div>
    </header>

      <table>
        <thead>
          <tr>
            <th align="left"><b>NO</b></th>
            <th align="left">QTY</th>
            <th class="service">UNIT</th>
            <th class="desc">DESCRIPTION</th>
            <th align="right">REMARK</th>
          </tr>
        </thead>
        <tbody>
            @foreach($dataR as $dR)
            <tr>
                <td class="qty">{{$loop->iteration}}</td>
                <td align="left">{{ $dR->quantity }}</td>
                <td class="service">{{ $dR->unit }}</td>
                <td class="desc">{{ $dR->desc }}</td>
                <td align="right">{{ $dR->remark }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>

        <!-- Requestor, Approved by, Acknowledged by cards -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Prepared by : <a href=""></a>
                    </div>
                    <div class="card-body">
                            <!-- Content for Approved by -->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="130" viewBox="0 0 582 569">
                            @include('layouts.partials.etowa_hod_stamp_green')
                            <text x="50%" y="50%" fill="green" font-size="74"  stroke="#00ff00" stroke-width="4" dominant-baseline="middle" text-anchor="middle">{{ $dataT->created_at->format('Y-m-d') }}</text>
                            <text x="50%" y="80%" fill="green" font-size="64"  stroke="#00ff00" stroke-width="4" dominant-baseline="middle" text-anchor="middle">{{ App\Models\User::find($dataT->user_id)->name }}</text>
                            </svg>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Approved by : <a href=""></a>
                    </div>
                    <div class="card-body">
                            <!-- Content for Approved by -->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="130" viewBox="0 0 582 569">
                            @include('layouts.partials.etowa_hod_stamp_green')
                            <text x="50%" y="50%" fill="green" font-size="74"  stroke="#00ff00" stroke-width="4" dominant-baseline="middle" text-anchor="middle">{{ $dataT->date_approval }}</text>
                            <text x="50%" y="80%" fill="green" font-size="64"  stroke="#00ff00" stroke-width="4" dominant-baseline="middle" text-anchor="middle">{{ App\Models\User::find($dataT->approved_user_id)->name }}</text>
                            </svg>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Checked by : <a href=""></a>
                    </div>
                    <div class="card-body">
                        <!-- Content for Approved by -->
                        @if ($dataT->checked_user_id == null)
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="130" viewBox="0 0 582 569">
                            @include('layouts.partials.etowa_hod_stamp_green')
                            <text x="50%" y="50%" fill="green" font-size="74"  stroke="#00ff00" stroke-width="4" dominant-baseline="middle" text-anchor="middle">{{ $dataT->date_verify }}</text>
                            <text x="50%" y="80%" fill="green" font-size="64"  stroke="#00ff00" stroke-width="4" dominant-baseline="middle" text-anchor="middle">{{ App\Models\User::find($dataT->checked_user_id)->name }}</text>
                        </svg>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 no-print">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Item Images
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($dataR as $dRi)
                                @php
                                    $imageUrls = json_decode($dRi->image_url, true);
                                    $checkedimageUrls = json_decode($dRi->checked_image_url, true);
                                    $requestIndex = $loop->index + 1;
                                @endphp
                                @foreach ($imageUrls as $img)
                                    <div class="col-md-4 mb-3">
                                        <small>Image by {{ App\Models\User::find($dataT->user_id)->name }} for Item no. {{$requestIndex}}</small>
                                        <a href="{{ asset($img) }}" target="_blank">
                                            <img src="{{ asset($img) }}" alt="Image" class="img-fluid img-thumbnail" style="object-fit: cover; width: 300px; height: 200px;">
                                        </a>
                                    </div>
                                @endforeach
                                @php
                                    if($checkedimageUrls  === null){
                                        $checkedimageUrls  = [];
                                    }
                                @endphp
                                @foreach ($checkedimageUrls as $Cimg)
                                    @php
                                        $loop->iteration++;
                                    @endphp
                                    <div class="col-md-4 mb-3">
                                        <small>Image by {{ App\Models\User::find($dataT->checked_user_id)->name }} for Item no. {{$requestIndex }}</small>
                                        <a href="{{ asset($Cimg) }}" target="_blank">
                                            <img src="{{ asset($Cimg) }}" alt="Image" class="img-fluid img-thumbnail" style="object-fit: cover; width: 300px; height: 200px;">
                                        </a>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="mt-3" id="notices">
        <div>ITEMS NOTE:</div>
        @foreach($dataR as $dR)
        <div class="notice">Item {{$loop->iteration}}: {{$dR->note}}</div>
        @endforeach
      </div>
      {{-- <div class="mt-3" id="notices">
        <div>SECURITY NOTE:</div>
        @foreach($dataR as $dR)
        <div class="notice">Item {{$loop->iteration}}: {{$dR->note}}</div>
        @endforeach
      </div> --}}

  </body>
</html>
