
  <a href="{{ route('gatepass') }}" class="list-group-item list-group-item-action border-0 align-items-center @if (request()->route()->named('gatepass')) active @endif">
      <span class="bi bi-receipt"></span>
      <span class="ml-2">Request GatePass</span>
  </a>

    @if (auth()->user()->role === 'admin')
    <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#sale-collapse">
    <div>
        <span class="bi bi-person-gear"></span>
        <span class="ml-2">@if (auth()->user()->role === 'admin')Admin Menu @else Part Menu @endif</span>
    </div>
    <span class="bi bi-chevron-down small"></span>
    </button>
    <div class="@if(request()->route()->named('account') || request()->route()->named('partlist') || request()->route()->named('assetcode')) collapse show @else collapse @endif" id="sale-collapse" data-parent="#sidebar">
        <div class="list-group">
            @if (auth()->user()->role === 'admin')
            <a href="{{ route('account') }}" class="list-group-item list-group-item-action border-0 pl-5 @if(request()->route()->named('account')) active @endif ">Account</a>
            @endif
        </div>
    </div>
    @endif

  <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#approval">
    <div>
      <span class="bi bi-person-workspace"></span>
      <span class="ml-2">GatePass Menu</span>
    </div>
    <span class="bi bi-chevron-down small"></span>
  </button>
  <div class="@if(request()->route()->named('gatepassPending') || request()->route()->named('gatepassApproved') || request()->route()->named('gatepassRejected')) collapse show @else collapse @endif" id="approval" data-parent="#sidebar">
    <div class="list-group">

        <a href="{{ route('gatepassPending') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('gatepassPending')) active @endif">Pending</a>
        <a href="{{ route('gatepassApproved') }}" class="list-group-item list-group-item-action border-0 pl-5 @if (request()->route()->named('gatepassApproved')) active @endif">Approved</a>

    </div>
  </div>

  <a href="#" class="list-group-item list-group-item-action border-0 align-items-center @if (request()->route()->named('log')) active @endif">
      <span class="bi bi-receipt"></span>
      <span class="ml-2">Log History</span>
  </a>
</div>
</div>
