<!-- Button trigger modal 
<button type="button" class="btn btn-primary float-right mb-2" data-toggle="modal" data-target="#model">
    Add Record
</button>
-->

<!-- Add Record Modal -->
<div class="modal fade" id="model" tabindex="-1" aria-labelledby="add_emp" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="add_emp">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="add_form">

                    <div class="form-group">
                        <label for="First Name">First name</label>
                        <input type="text" class="form-control" id="name" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="First Name">Address</label>
                        <input type="text" class="form-control" id="address" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="First Name">Salary</label>
                        <input type="text" class="form-control" id="salary" value="" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save_record">Save</button>
            </div>
        </div>
    </div>
</div>
