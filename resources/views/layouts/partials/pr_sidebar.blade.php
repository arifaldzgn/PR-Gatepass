@if (auth()->user()->role === 'admin' or auth()->user()->role === 'hod' or auth()->user()->role === 'hod2')
    <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#sale-collapse">
        <div>
        <span class="bi bi-person-gear"></span>
        <span class="ml-2">@if (auth()->user()->role === 'admin' or auth()->user()->role === 'hod' or auth()->user()->role === 'hod2')Admin Menu @else Part Menu @endif</span>
        </div>
        <span class="bi bi-chevron-down small"></span>
    </button>
    <div class="@if(request()->route()->named('account') || request()->route()->named('partlist') || request()->route()->named('assetcode')) collapse show @else collapse @endif" id="sale-collapse" data-parent="#sidebar">
        <div class="list-group">
        @if (auth()->user()->role === 'admin' or auth()->user()->role === 'hod')
        <a href="{{ route('account') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('account')) active @endif">Account</a>
        @endif
        <a href="{{ route('partlist') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('partlist')) active @endif">Part List</a>
        {{-- <a href="{{ route('assetcode') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('assetcode')) active @endif">Part Asset Code</a> --}}
        </div>
    </div>
@endif

  <a href="{{ route('pr_request') }}" class="list-group-item list-group-item-action border-0 align-items-center @if (request()->route()->named('pr_request')) active @endif">
      <span class="bi bi-receipt"></span>
      <span class="ml-2">Request PR</span>
  </a>
  <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#approval">
    <div>
      <span class="bi bi-person-workspace"></span>
      <span class="ml-2">PR Menu</span>
    </div>
    <span class="bi bi-chevron-down small"></span>
  </button>
  <div class="@if(request()->route()->named('pending') || request()->route()->named('approved') || request()->route()->named('rejected')) collapse show @else collapse @endif" id="approval" data-parent="#sidebar">
    <div class="list-group">
      <a href="{{ route('pending') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('pending')) active @endif">Pending</a>
      <a href="{{ route('approved') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('approved')) active @endif">Approved</a>
      <a href="{{ route('rejected') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('rejected')) active @endif">Rejected</a>
    </div>
  </div>
  <a href="{{ route('log') }}" class="list-group-item list-group-item-action border-0 align-items-center @if (request()->route()->named('log')) active @endif">
      <span class="bi bi-receipt"></span>
      <span class="ml-2">Log History</span>
  </a>
</div>
</div>
