
<div class="modal fade" id="createPr" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="createPrLabel">New Purchase Requisition</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
          <!--  -->
        <div class="container">
        <form id="createPrForm" method="POST" action="{{ route('pr_request_create') }}">
            <div class="card mb-3 card-body border border-primary">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label>Enable advance cash</label>
                </div>
                <div class="form-group">
                    <input type="number" id="cashAdvance" class="form-control" name="advance_cash" disabled>
                    <small class="form-text text-muted">This will refer to the total amount of this PR</small>
                </div>
            </div>
            <div id="prRequestForm">
                @csrf
                <!-- Material Request Information -->
            </div>
            </div>
            <div class="d-grid col-6 mx-auto">
                <button class="btn btn-primary btn-block" id="addItem" type="button">Add New Items</button>
            </div>
        </div>
        {{-- <button type="submit" class="btn btn-primary btn-block">Submit Request 2</button> --}}
        </form>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-block" id="submitRequest" disabled>Submit Request</button>
            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
        </div>
    </div>
    </div>
</div>


  <div class="modal" tabindex="-1" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this part?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>

<!-- View Details & Update Material Modal -->
<div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="materialModalLabel">Part Request Detail</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display material data -->
                <div class="card mb-3 card-body border border-primary">
                        <label>Advance cash</label>
                        <input type="number" id="typeNumber" class="form-control" name="advance_cash">
                        <small class="form-text text-muted">This will refer to the total advance cash amount of this PR</small>
                </div>
                <form id="materialDataForm" method="POST">
                    <!-- Form content will be appended here by JavaScript -->
                </form>
            </div>
            <div class="modal-footer">
                @if (Route::currentRouteName() !== 'rejected')
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pic' || auth()->user()->role === 'hod')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="button" class="btn btn-danger" id="rejectButton">Reject</button>
                    <button type="button" class="btn btn-success" id="approveButton">Approve</button>
                    @endif
                @endif
                <button type="button" class="btn btn-primary" id="saveMaterialChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal" tabindex="-1" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this item?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Reject Reason Modal -->
<div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectReasonModalLabel">Reason to Reject</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cancel">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rejectReasonForm">
                    <div class="form-group">
                        <label for="rejectReasonTextarea">Reason:</label>
                        <textarea class="form-control" id="rejectReasonTextarea" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmRejectButton">Confirm Reject</button>
            </div>
        </div>
    </div>
</div>
