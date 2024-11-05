


<div class="modal fade" id="createAccountModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="createAccountModalLabel">Create Account</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <!--  -->
          <div class="container">
          <form id="createAccountForm" method="POST">
              @csrf
              <!-- Material Request Information -->
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Employee Name" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Badge <small class="small-text text-secondary">as Username</small></label>
                <input type="text" class="form-control" name="badge_no" placeholder="Employee Badge" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Employee Email" required>
              </div>
              <div class="mb-3">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Department</label>
                    <select class="form-control" name="deptList_id">
                      @foreach ($deptList as $dl)
                        <option value="{{ $dl->id }}">{{ $dl->dept_name }}</option>
                      @endforeach
                    </select>
                  </div>
              </div>
              <div class="mb-3">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Role</label>
                    <select class="form-control" name="role">
                        <option value="hod">HOD  | PIC</option>
                        <option value="hod2">HOD  | GatePass Approval</option>
                        <option value="regular">Clerk | Regular</option>
                        <option value="security">Security | Regular</option>
                    </select>
                  </div>
              </div>
              </div>
              </div>
              <div class="card-footer text-muted">
                The default password for all users is <a class="text-primary">12345</a>
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
          Are you sure you want to delete this user?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateUserModalLabel">Update User Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateUserForm">
            <input type="hidden" id="userId" name="userId">
            <div class="mb-3">
              <label for="userName" class="form-label">Name</label>
              <input type="text" class="form-control" id="userName" name="userName" required>
            </div>
            <div class="mb-3">
              <label for="userEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="userEmail" name="userEmail" required>
            </div>
            <div class="mb-3">
              <label for="userDepartment" class="form-label">Department</label>
              <input type="text" class="form-control" id="userDepartment" name="userDepartment" required>
            </div>
            <div class="mb-3">
              <label for="userRole" class="form-label">Role</label>
              <select class="form-select" id="userRole" name="userRole" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Action --}}
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Account Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form fields for editing/inputting -->
                <form id="editForm">
                    <input type="hidden" id="partId">
                    <div class="form-group">
                        <label for="name">Employee Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="badge_no">Badge No</label>
                        <input type="text" class="form-control" id="badge_no" name="badge_no" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Employee Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="hod">Hod Email</label>
                        <input type="hod" class="form-control" id="hod" name="hod" disabled>
                    </div>
                    <div class="form-group">
                        <label>Dept Name</label>
                        <select name="deptList_id" id="dept" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="hod">HOD  | PIC</option>
                            <option value="hod2">HOD  | GatePass Approval</option>
                            <option value="regular">Clerk | Regular</option>
                            <option value="security">Security | Regular</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
