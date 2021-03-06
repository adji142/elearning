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
			      Management Soal dan Quis
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
	                <h4 class="modal-title">Tambah Soal / Quis</h4>
	            </div>
	            <div class="modal-body">
	                <form class="form-horizontal" role="form" id="post_">
	                    <input type="hidden" name="id" id="id" >
	                    <input type="hidden" name="formtype" id="formtype" value="add">
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Kode Soal</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="KodeSoal" name="KodeSoal" placeholder="Nama Guru" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Mata Pelajaran</label>
	                        <div class="col-lg-8">
	                        	<input list="listMapel" name="MapelID" id="MapelID" class="form-control" autocomplete="off">
	                            <datalist id="listMapel" >
	                            	<?php
	                            		$rs = $this->db->query("select * from tmapel order by KodeMapel")->result();
	                            		foreach ($rs as $key) {
	                            			echo "<option value = '".$key->id."|".$key->NamaMapel."'>";
	                            		}
	                            	?>
	                            </datalist>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Guru</label>
	                        <div class="col-lg-8">
	                        	<input list="listGuru" name="NIKGuru" id="NIKGuru" class="form-control" autocomplete="off">
	                            <datalist id="listGuru" >
	                            	<?php
	                            		$rs = $this->db->query("select * from tguru order by NamaGuru")->result();
	                            		foreach ($rs as $key) {
	                            			echo "<option value = '".$key->NomorIndukGuru."|".$key->NamaGuru."'>";
	                            		}
	                            	?>
	                            </datalist>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Kelas</label>
	                        <div class="col-lg-8">
	                        	<input list="listKelas" name="KelasID" id="KelasID" class="form-control" autocomplete="off">
	                            <datalist id="listKelas" >
	                            	<?php
	                            		$rs = $this->db->query("select * from tkelas order by KodeKelas")->result();
	                            		foreach ($rs as $key) {
	                            			echo "<option value = '".$key->id."|".$key->NamaKelas."'>";
	                            		}
	                            	?>
	                            </datalist>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Waktu</label>
	                        <div class="col-lg-8">
	                            <input type="time" class="form-control" id="Waktu" name="Waktu"required="" autocomplete="off" >
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Keterangan</label>
	                        <div class="col-lg-8">
	                            <textarea class="form-control" id="Keterangan" name="Keterangan" placeholder="Keterangan" required=""></textarea>
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
		var _URL = window.URL || window.webkitURL;
		$(document).ready(function () {
			$.ajax({
              type: "post",
              url: "<?=base_url()?>Managementsoal/readtopik",
              data: {'id':''},
              dataType: "json",
              success: function (response) {
                bindGrid(response.data);
              }
            });
		});
		$('.close').click(function() {
            location.reload();
        });
		$("#Attachment").change(function(){
	      // readURL(this);
	      encodeImagetoBase64(this);
	      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
	    });
        $('#post_').submit(function (e) {
            $('#btn_Save').text('Tunggu Sebentar.....');
            $('#btn_Save').attr('disabled',true);

            e.preventDefault();
            var me = $(this);

            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>Managementsoal/CRUDTopik',
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
        function readURL(input) {
		    if (input.files && input.files[0]) {
		      var reader = new FileReader();
		        
		      reader.onload = function (e) {
		          $('#profile-img-tag').attr('src', e.target.result);
		      }
		      reader.readAsDataURL(input.files[0]);
		    }
		  }
		  function encodeImagetoBase64(element) {
		    $('#FileItem').val('');
		      var file = element.files[0];
		      var reader = new FileReader();
		      reader.onloadend = function() {
		        // $(".link").attr("href",reader.result);
		        // $(".link").text(reader.result);
		        $('#FileItem').val(reader.result);
		      }
		      reader.readAsDataURL(file);
		  }
        function GetData(id) {
            var where_field = 'id';
            var where_value = id;
            var table = 'tkelas';
            $.ajax({
              type: "post",
              url: "<?=base_url()?>Managementsoal/readtopik",
              data: {'id':id},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    console.log(v.Waktu);
                    $('#KodeSoal').val(v.KodeSoal);
                    $('#MapelID').val(v.KodeMapel + '|' + v.NamaMapel);
					$('#NIKGuru').val(v.NIKGuru + '|' + v.NamaGuru);
					$('#KelasID').val(v.KodeKelas + '|' + v.NamaKelas);
					$('#Keterangan').val(v.Keterangan);
					$('#Waktu').val(v.WaktuSoal);

                    $('#id').val(v.id);
                    $('#formtype').val("edit");

                    $('#modal_').modal('show');
                  });
              }
            });
        }
		function bindGrid(data) {
			var x = $('#hakakes').val();
			var allowAdding = true;
			var visibling = false;
			if (x == 3) {
				allowAdding = false;
				visibling = true;
			}
	        $("#gridContainer").dxDataGrid({
	            allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "id",
	            showBorders: true,
	            allowColumnReordering: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            filterRow: { visible: true },
		        filterPanel: { visible: true },
		        headerFilter: { visible: true },
	            paging: {
	                enabled: true
	            },
	            editing: {
	                mode: "row",
	                allowAdding: allowAdding,
	                allowUpdating: allowAdding,
	                allowDeleting: allowAdding,
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
	                    dataField: "KodeSoal",
	                    caption: "Kode Soal",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaKelas",
	                    caption: "Nama Kelas",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaMapel",
	                    caption: "Mata Pelajaran",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Nilai",
	                    caption: "Nilai",
	                    allowEditing:false,
	                    visible: visibling
	                },
	                {
	                    dataField: "Keterangan",
	                    caption: "Deskripsi Soal",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Createdon",
	                    caption: "Dibuat Tanggal",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Createdby",
	                    caption: "Dibuat Oleh",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Waktu",
	                    caption: "Waktu",
	                    allowEditing:false
	                },
	                {
	                    dataField: "FileItem",
	                    caption: "Action",
	                    allowEditing:false,
	                    cellTemplate: function(cellElement, cellInfo) {
	                    	var LinkAccess = "";
	                    	console.log();
	                    	if (x == 3) {
	                    		if (cellInfo.data.Jml > 0) {
	                    			LinkAccess = "<span class='badge badge-primary'>Sudah diKerjakan</span>";
	                    		}
	                    		else{
	                    			LinkAccess = "<a href = '<?=base_url()?>jawabsoal/"+cellInfo.data.id+"' class='badge badge-primary'>Kerjakan</a>";
	                    		}
	                    	}
	                    	else{
	                    		LinkAccess = "<a href = '<?=base_url()?>addsoal/"+cellInfo.data.id+"' class='badge badge-primary'>Buat Soal</a> <a href = '<?=base_url()?>viewsoal/"+cellInfo.data.id+"' class='badge badge-success'>Lihat Soal</a><br> <a href = '<?=base_url() ?>reviewpeserta/"+cellInfo.data.id+"' class='badge badge-danger'>Peserta & Koreksi</a>";
	                    	}
		                    cellElement.append(LinkAccess);
		                }
	                },
	                // {
	                //     dataField: "Nilai",
	                //     caption: "Nilai",
	                //     allowEditing:false
	                // },
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
	                        url     : '<?=base_url()?>Managementsoal/CRUDTopik',
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