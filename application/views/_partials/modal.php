<div class="modal fade" id="modal-4">
	<div class="modal-dialog" style="width: 50%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Customer</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;Nama Customer</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="nama_customer" name="nama_customer" placeholder="AHM" required/>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style="margin-top: 50px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" type="submit" id="btn_save" class="btn btn-primary">Save</button>
            </div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit">
	<div class="modal-dialog" style="width: 50%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Ubah Customer</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<input type="hidden" id="id_customer_edit" name="id_customer_edit">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;Nama Customer</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="nama_customer_edit" name="nama_customer_edit" placeholder="AHM" required/>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style="margin-top: 50px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" type="submit" id="btn_update" class="btn btn-primary">Ubah</button>
            </div>
		</div>
	</div>
</div>

<div class="modal fade" id="Modal_Delete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<strong>Anda yakin menghapus customer <span id="customer_name_delete"></span>? </strong>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_customer_delete" id="id_customer_delete" class="form-control">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            	<button type="button" type="submit" id="btn_delete" class="btn btn-primary">Yes</button>
            </div>
    	</div>
    </div>
</div>
