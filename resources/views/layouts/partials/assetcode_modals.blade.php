
<div class="modal fade" id="createAssetCode" aria-hidden="true" aria-labelledby="createAssetCodeLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="createAssetCodeLabel">Create New Part</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!--  -->
          <div class="container">
          <form id="createAssetCodeForm" method="POST">
              @csrf
              <!-- Material Request Information -->
              <div class="mb-3">
                <label class="form-label">Asset Code</label>
                <input type="text" class="form-control" name="asset_code" placeholder="Asset Code">
              </div>
              <div class="mb-3">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Department Code</label>
                    <select class="form-control" name="dept_code">
                        @foreach ($dept as $dpt)
                        <option value="{{ $dpt->dept_code }}">{{ $dpt->dept_code }} | {{ $dpt->dept_name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              </div>
            </div>
            </form>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success btn-block" id="submitRequest">Submit Request</button>
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
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this assetCode?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>
