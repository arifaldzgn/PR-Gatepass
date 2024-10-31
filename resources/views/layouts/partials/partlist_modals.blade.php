
<div class="modal fade" id="createPartList" aria-hidden="true" aria-labelledby="createPartListLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="createPartListLabel">Create New Part</h3>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <!--  -->
          <div class="container">
          <form id="createPartlistForm" method="POST">
            @csrf
            <!-- Material Request Information -->
            <div class="mb-3">
                <label class="form-label">Item Type</label>
                <select class="form-control" id="itemTypeSelector">
                    <option value="none" selected>None</option>
                    <option value="stock">Stock</option>
                    <option value="non-stock">Non-Stock</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="part_name" placeholder="Part/Item/Service Name" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="type" placeholder="Description" disabled>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label>Part Category</label>
                    <select class="form-control" name="category" disabled>
                        <option value="Asset">Asset</option>
                        <option value="Consumable">Consumable</option>
                        <option value="License">License</option>
                        <option value="Service">Service</option>
                        <option value="Software">Software</option>
                        <option value="Spare Part">Spare Part</option>
                        <option value="Subscription">Subscription</option>
                        <option value="System">System</option>
                        <option value="Stationery">Stationery</option>
                    </select>
                </div>
            </div>
            <div class="mb-3" id="stockField" style="display: none;">
                <label class="form-label">Current Stocks</label>
                <input type="number" class="form-control" name="stocks" disabled>
            </div>

            <div class="mb-3" id="UoM" style="display: none;">
                <label class="form-label">UoM</label>
                <input type="text" class="form-control" name="UoM" placeholder="example: years/unit/pcs/user" disabled>
            </div>

            </div>
            </form>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success btn-block" id="submitRequest">Submit Request</button>
              <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
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
            Are you sure you want to delete this part?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
        </div>
    </div>

    {{-- Action --}}
    <div class="modal" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Part Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing/inputting -->
                    <form id="editForm">
                        <input type="hidden" id="partId">
                        <div class="form-group">
                            <label for="partName">Part Name</label>
                            <input type="text" class="form-control" id="partName" name="part_name">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="stock">Available Stock</label>
                            <input type="number" class="form-control" id="stock" readonly>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                            <small class="form-text text-muted">Enter positive numbers (0+) to increase stock, and vice versa</small>
                        </div>
                        <input type="hidden" name="part_id" id="part_id">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
