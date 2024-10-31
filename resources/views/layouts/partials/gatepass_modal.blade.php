<div class="modal fade" id="createPr" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="createPrLabel"><center>New GatePass Request</center></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
          <!--  -->
        <div class="container">
        <form id="createPrForm" method="POST" action="{{ route('create_gatepass') }}" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3 card-body border border-primary">
                <div class="mb-3">
                    <label class="form-label" for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="company_address">Company Address</label>
                    <input type="text" class="form-control" id="company_address" name="company_address">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="company_employee">Company Employee Name</label>
                    <input type="text" class="form-control" id="company_employee" name="company_employee">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="company_vehno">Company Vehicle Number</label>
                    <input type="text" class="form-control" id="company_vehno" name="company_vehno">
                </div>
            </div>
            <div class="d-grid col-10 mx-auto mb-5 mt-5">
                <h6 class="form-text text-muted">Akan membawa keluar barang-barang di bawah ini dari lingkungan perusahaan.</h6>
            </div>
            <div id="prRequestForm">

            </div>
            </div>
            <div class="d-grid col-6 mx-auto">
                <button class="btn btn-primary btn-block" id="addItem" type="button">Add New Items</button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Submit Request 2</button>
        </form>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-block" id="submitRequest" disabled>Submit Request</button>
            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
        </div>
    </div>
    </div>
</div>
