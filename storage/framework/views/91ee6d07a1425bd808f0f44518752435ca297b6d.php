<?php echo $__env->make('layouts._menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .btn>.btn-add{
        cursor: pointer;
    }
    #add-btn {
        background-color: #4074e6;
        border-color: #101ee2;
        color: #ffffff;
    }
    #add-btn:hover {
        background-color: #123786;
        color: #ffffff;
    }
    .content-box-title{
        background-color: #2f6495;
        color: #ffffff;
    }
    
    .dataTables_scrollHeadInner {   
        padding:0% ! important
    }
    .modal-backdrop{
        display: none;
    }
    .nowrap{
        white-space: nowrap;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts._flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php echo Form::open(['url' => route('gismobile.surat.store'), 'method' => 'post', 'files'=>'true', 'id'=>'form_id']); ?>

<div class="content-container">
        <div class="content-box-title"><label>Input Surat Jalan</label></div>
        <div class="box-body form-horizontal">
            <div class="row form-group">
                <div class="col-sm-12">
                <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'No Surat'); ?>

                            <?php echo Form::text('no_surat', null, ['class'=>'form-control','placeholder' => 'Otomatis', 'name' => 'no_surat', 
                            'id' => 'no_surat', 'readonly'=>'true']); ?>

                        </div>

                        <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'No PO'); ?>

                            <?php echo Form::text('no_po', null, ['class'=>'form-control','placeholder' => 'Otomatis', 'name' => 'no_po', 
                            'id' => 'no_po', 'readonly'=>'true']); ?>

                        </div>

						<div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'No Kendaraan'); ?>

                            <?php echo Form::text('kendaraan', null, ['class'=>'form-control','placeholder' => 'Nomor', 'name' => 'kendaraan', 
                            'id' => 'kendaraan']); ?>

                        </div>
                    
                    <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Tanggal</label>
                        <?php echo Form::date('tglakhir', \Carbon\Carbon::now(), ['class'=>'form-control', 'id' => 'tglakhir']); ?>

                        <?php echo Form::hidden('bulan_temp', \Carbon\Carbon::now()->format('m'), ['id'=>'bulan_temp', 'name'=>'bulan_temp']); ?>

                    </div>
                </div>
                </div>
                
            </div>
        </div>

        <div class="content-container">
	<div class="content-box-title"><label>Tabel Surat</label></div>
	<div class="row">
		<div class="col-sm-12">
			<div style="overflow: auto;">
                  <table class="table table-hover table-striped table-inspect" id="table-inspect"> 
					<thead>
						<tr>
							<th>No</th>
							<th>No Kirim</th>
							<th>Part Number</th>
							<th>Part Name</th>
							<th>Nama Gudang</th>
							<th>Qty Kirim</th>
							<th>
								<button type="button" class="btn btn-secondary btn-xs" id="btn-add-data">
									<i class="fa fa-plus" style="color: black; cursor: pointer; display: inline;"></i>
								</button>
							</th>
						</tr>
					</thead>
					<tbody id="body_item"></tbody>
				</table>
				<div>
                            <button type="submit" id="sub-btn" class="btn btn-primary" style="float:right;">
                                <i></i> Simpan
                            </button>
                        </div>
<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

    <?php echo $__env->make('surat._modal-surat-tambah', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
//=============================TABLE DETAIL================================
$('#btn-add-data').on('click', function() {
		addRowData();
	});
	function addRowData() {
		var row = $('#table-inspect tbody tr').length;
		row = row + 1;
		$('#table-inspect tbody').append('\
		<tr id="row">\
			<td class="dt-center" style="vertical-align: middle;"><center>'+row+'</center></td>\
			<td class="dt-center">\
				<div class= "input-group">\
					<input type="text" name="no_kirim[]" class="form-control" id="no_kirim_'+row+'" readonly="readonly">\
					<span class="input-group-btn">\
						<button id="no_kirim_'+row+'" name="no_kirim[]" type="button" class="btn btn-info" onclick="getIdkirim(this.id)"">\
							<i class="fa fa-search custom-icon-info"></i>\
						</button>\
					</span>\
				</div>\
			</td>\
			<td class="dt-center">\
				<input type="text" name="no_produk[]" class="form-control" id="no_produk_'+row+'" readonly="readonly">\
			</td>\
			<td class="dt-center">\
				<input type="text" name="nama_produk[]" class="form-control" id="nama_produk_'+row+'" readonly="readonly">\
			</td>\
			<td class="dt-center">\
				<input type="text" name="nama_gudang[]" class="form-control" id="nama_gudang_'+row+'" readonly="readonly">\
			</td>\
			<td class="dt-center">\
				<input type="number" name="qty_kirim[]" class="form-control" id="qty_kirim_'+row+'" readonly="readonly">\
			</td>\
			<td class="dt-center">\
				<center><button type="button" class="btn btn-xs btn-danger" name="btn_delete[]" id="btn-delete_'+row+'" onclick="hapusRow((this.id), (this.id), \'row\')"><i class="fa fa-trash"></i></button></center>\
			</td>\
		</tr>').children(':last')
	}

    function hapusRow(id, no_kirim, del_type) {
			var row_index = $('#' + id).closest('tr').index() + 1;
			console.log(row_index);
			document.getElementById('table-lhp').deleteRow(row_index);
			SortColumn();
	}
	function SortColumn() {
		$('#table-lhp').each(function () {
			var columnFirst = 1;
			var i = 1;
			$("tbody",this).find('tr').each(function () { //belom ganti tiap field
				var currentTd = $(this).find('td:nth-child(' + columnFirst + ')');
				// $(this).find("td:eq(0)").html(i);
				$(this).find("td:eq(1) input").attr('id', 'no_kirim_' + i);
				$(this).find("td:eq(1) button").attr('id', 'no_kirim_' + i);
				$(this).find("td:eq(2) input").attr('id', 'tgl_kirim_' + i);
				$(this).find("td:eq(3) input").attr('id', 'no_produk_' + i);
				$(this).find("td:eq(4) input").attr('id', 'nama_produk_' + i);
				$(this).find("td:eq(5) input").attr('id', 'nama_gudang_' + i);
				$(this).find("td:eq(6) input").attr('id', 'qty_kirim_' + i);
				currentTd.html(i);
				i++;
			});
		});
	}

	function getIdkirim(id){
		index_row = id;
		var row = $('#table-lhp tbody tr').length;
			$('#modalT').modal('show');
			
			var url = '<?php echo e(route("gismobile.surat.modal")); ?>'
			
			var tblt = $('#tablet').DataTable({
				processing: true, 
				serverSide: false,
				"pagingType": "numbers",
				ajax: url,
				"scrollX": true,
				"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
				"order": [[0, 'asc']],
				columns: [
				{ data: 'DT_Row_Index', name:'DT_Row_Index', orderable:false, searchable:false },  
				{ data: 'no_kirim' },
				{ data: 'tgl_kirim' },
				{ data: 'no_produk' },
				{ data: 'nama_produk' },
				{ data: 'nama_gudang' },
				{ data: 'qty_kirim' },
				],
				"bDestroy": true,
				"initComplete": function(settings, json) {
					$('#tablet tbody').on( 'click', 'tr', function () {
						var dataArr = [];
						var rows = $(this);
						var rowData = tblt.rows(rows).data();
						$.each($(rowData),function(key,value){
							$("#no_kirim_" + index_row.substr(9)).val(value["no_kirim"])
							$("#no_produk_" + index_row.substr(9)).val(value["no_produk"])
							$("#nama_produk_" + index_row.substr(9)).val(value["nama_produk"])
							$("#nama_gudang_" + index_row.substr(9)).val(value["nama_gudang"])
							$("#qty_kirim_" + index_row.substr(9)).val(value["qty_kirim"])
							$("#no_kirim_" + index_row.substr(9)).trigger('change')
							$('#modalT').modal('hide');
						});
					});
				},
			});
		}

$('#form_scpag').submit(function (e, params) {
	var localParams = params || {};
	console.log(localParams);
	if (!localParams.send) {
		e.preventDefault();
		swal({
			title: 'Yakin?',
			text: 'Anda akan menyimpan Cutting Order ini. Pastikan data lengkap & benar',
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Ya',
			cancelButtonText: '<i class="fa fa-thumbs-down"></i> Kembali',
			allowOutsideClick: true,
			allowEscapeKey: true,
			allowEnterKey: true,
			reverseButtons: false,
			focusCancel: true,
		}).then(function () {                
			showLoading()
			$.ajax({
				url: "<?php echo e(route('gismobile.surat.store')); ?>",
				type: 'post',
				data: $("#form_scpag").serialize(), // Remember that you need to have your csrf token included
				dataType: 'json',
				success: function( _response ){
					if (_response.nummer == "1"){
						swal("Sukses", _response.msg, "success")
					} else if (_response.nummer == "2"){ // cek sudah approve
						swal("Perhatian", _response.msg, "warning")
					} else {
						swal("Info", _response.msg, "info")
					}
					hideLoading()
				},
				error: function(xhr, textStatus, errorThrown){
					swal(
						'Terjadi kesalahan',
						'Error: '+xhr.status+'<br>'+errorThrown+'<br> Status: '+xhr.responseText,
						'info'
						)
						hideLoading()
					}
				});
			}, function (dismiss) {    
				if (dismiss === 'cancel') {
				}
			})
		}
	});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>