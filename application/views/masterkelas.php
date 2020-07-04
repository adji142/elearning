<?php
    require_once(APPPATH."views/part/header.php");
    require_once(APPPATH."views/part/sidebar.php");
?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!-- //market-->
		<div class="table-agile-info">
			<div class="panel panel-default">
				<div class="panel-heading">
			      Master Kelas
			    </div>
			    <div class="row w3-res-tb">
			    	<div class="col-md-12 w3ls-graph">
						<div class="dx-viewport demo-container">
				            <div id="data-grid-demo">
				                <div id="gridContainer">
				                </div>
				            </div>
				        </div>
					</div>
			    </div>
			    
			</div>
		</div>
	</section>
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	                <h4 class="modal-title">Tambah Kelas</h4>
	            </div>
	            <div class="modal-body">
	                <form class="form-horizontal" role="form" id="post_">
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Kode Kelas</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="KodeKelas" name="KodeKelas" placeholder="Kode Kelas" required="" autocomplete="off">
	                            <input type="hidden" name="id" id="id" >
	                            <input type="hidden" name="formtype" id="formtype" value="add">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Nama Kelas</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NamaKelas" name="NamaKelas" placeholder="Nama Kelas" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div class="col-lg-offset-2 col-lg-10">
	                            <button class="btn btn-default" id="btn_Save" class="btn_Save">Simpan</button>
	                        </div>
	                    </div>
	                </form>

	            </div>

	        </div>
	    </div>
	</div>
<?php
    require_once(APPPATH."views/part/footer.php");
?>

<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
			$.ajax({
              type: "post",
              url: "<?=base_url()?>Apps/read",
              data: {'table':'tkelas'},
              dataType: "json",
              success: function (response) {
                bindGrid(response.data);
              }
            });
		});
		$('.close').click(function() {
            location.reload();
        });

        $('#post_').submit(function (e) {
            $('#btn_Save').text('Tunggu Sebentar.....');
            $('#btn_Save').attr('disabled',true);

            e.preventDefault();
            var me = $(this);

            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>Mstr_kelas/CRUD',
                data    : me.serialize(),
                dataType: 'json',
                success : function (response) {
                  if(response.success == true){
                    $('#modal_').modal('toggle');
                    Swal.fire({
                      type: 'success',
                      title: 'Horay..',
                      text: 'Data Berhasil disimpan!',
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result)=>{
                      location.reload();
                    });
                  }
                  else{
                    $('#modal_').modal('toggle');
                    Swal.fire({
                      type: 'error',
                      title: 'Woops...',
                      text: response.message,
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result)=>{
                        $('#modal_').modal('show');
                        $('#btn_Save').text('Save');
                        $('#btn_Save').attr('disabled',false);
                    });
                  }
                }
              });
        });
        function GetData(id) {
            var where_field = 'id';
            var where_value = id;
            var table = 'tkelas';
            $.ajax({
              type: "post",
              url: "<?=base_url()?>Apps/FindData",
              data: {where_field:where_field,where_value:where_value,table:table},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    console.log(v.KelompokUsaha);
                    $('#KodeKelas').val(v.KodeKelas);
                    $('#NamaKelas').val(v.NamaKelas);
                    $('#id').val(v.id);
                    $('#formtype').val("edit");

                    $('#modal_').modal('show');
                  });
              }
            });
        }
		function bindGrid(data) {

	        $("#gridContainer").dxDataGrid({
	            allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "id",
	            showBorders: true,
	            allowColumnReordering: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            paging: {
	                enabled: true
	            },
	            editing: {
	                mode: "row",
	                allowAdding:true,
	                allowUpdating: true,
	                allowDeleting: true,
	                texts: {
	                    confirmDeleteMessage: ''  
	                }
	            },
	            searchPanel: {
	                visible: true,
	                width: 240,
	                placeholder: "Search..."
	            },
	            export: {
	                enabled: true,
	                fileName: "Daftar Pelayan"
	            },
	            columns: [
	                {
	                    dataField: "KodeKelas",
	                    caption: "Kode Kelas",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaKelas",
	                    caption: "Nama Kelas",
	                    allowEditing:false
	                },
	            ],
	            onEditingStart: function(e) {
	                GetData(e.data.id);
	            },
	            onInitNewRow: function(e) {
	                // logEvent("InitNewRow");
	                $('#modal_').modal('show');
	            },
	            onRowInserting: function(e) {
	                // logEvent("RowInserting");
	            },
	            onRowInserted: function(e) {
	                // logEvent("RowInserted");
	                // alert('');
	                // console.log(e.data.onhand);
	                // var index = e.row.rowIndex;
	            },
	            onRowUpdating: function(e) {
	                // logEvent("RowUpdating");
	                
	            },
	            onRowUpdated: function(e) {
	                // logEvent(e);
	            },
	            onRowRemoving: function(e) {
	                id = e.data.id;
	                Swal.fire({
	                  title: 'Apakah anda yakin?',
	                  text: "anda akan menghapus data di baris ini !",
	                  icon: 'warning',
	                  showCancelButton: true,
	                  confirmButtonColor: '#3085d6',
	                  cancelButtonColor: '#d33',
	                  confirmButtonText: 'Yes, delete it!'
	                }).then((result) => {
	                  if (result.value) {
	                    var table = 'users';
	                    var field = 'id';
	                    var value = id;

	                    $.ajax({
	                        type    :'post',
	                        url     : '<?=base_url()?>Mstr_kelas/CRUD',
	                        data    : {'id':id,'formtype':'delete'},
	                        dataType: 'json',
	                        success : function (response) {
	                          if(response.success == true){
	                            Swal.fire(
	                              'Deleted!',
	                              'Your file has been deleted.',
	                              'success'
	                            ).then((result)=>{
	                              location.reload();
	                            });
	                          }
	                          else{
	                            Swal.fire({
	                              type: 'error',
	                              title: 'Woops...',
	                              text: response.message,
	                              // footer: '<a href>Why do I have this issue?</a>'
	                            }).then((result)=>{
	                                location.reload();
	                            });
	                          }
	                        }
	                      });
	                    
	                  }
	                  else{
	                    location.reload();
	                  }
	                })
	            },
	            onRowRemoved: function(e) {
	                // console.log(e);
	            },
	            onEditorPrepared: function (e) {
	                // console.log(e);
	            }
	        });
		}
	});
</script>