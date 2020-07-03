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
			      Pembelajaran
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
	                <h4 class="modal-title">Tambah Materi Kelas</h4>
	            </div>
	            <div class="modal-body">
	                <form class="form-horizontal" role="form" id="post_">
	                    <input type="hidden" name="id" id="id" >
	                    <input type="hidden" name="formtype" id="formtype" value="add">
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Mata Pelajaran</label>
	                        <div class="col-lg-8">
	                        	<input list="listMapel" name="MapelID" id="MapelID" class="form-control">
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
	                        	<input list="listGuru" name="NIKGuru" id="NIKGuru" class="form-control">
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
	                        	<input list="listKelas" name="KelasID" id="KelasID" class="form-control">
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
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Deskripsi Singkat</label>
	                        <div class="col-lg-8">
	                            <textarea class="form-control" id="ShortDesc" name="ShortDesc" placeholder="No. Telepon" required=""></textarea>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Deskripsi Lengkap</label>
	                        <div class="col-lg-8">
	                            <textarea class="form-control" id="LongDesc" name="LongDesc" placeholder="No. Telepon" required=""></textarea>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Deskripsi Lengkap</label>
	                        <div class="col-lg-8">
	                            <input type="file" id="Attachment" name="Attachment" accept=".pdf , .doc , .docx" />
	                            <textarea id="FileItem" name="FileItem" style=""></textarea>
	                            <!-- display: none; -->
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
              url: "<?=base_url()?>Pembelajaran/read",
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
                url     : '<?=base_url()?>Pembelajaran/CRUD',
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
              url: "<?=base_url()?>Pembelajaran/read",
              data: {'id':id},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    // console.log(v.KelompokUsaha);
                    $('#MapelID').val(v.KodeMapel + '|' + v.NamaMapel);
					$('#NIKGuru').val(v.NIKGuru + '|' + v.NamaGuru);
					$('#KelasID').val(v.KodeKelas + '|' + v.NamaKelas);
					$('#ShortDesc').val(v.ShortDesc);
					$('#LongDesc').val(v.LongDesc);
					$('#FileItem').val(v.FileItem);

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
	            filterRow: { visible: true },
		        filterPanel: { visible: true },
		        headerFilter: { visible: true },
	            paging: {
	                enabled: false
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
	                    dataField: "NamaGuru",
	                    caption: "Mata Guru",
	                    allowEditing:false
	                },
	                {
	                    dataField: "ShortDesc",
	                    caption: "Deskripsi",
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
	                    dataField: "FileItem",
	                    caption: "File",
	                    allowEditing:false,
	                    cellTemplate: function(cellElement, cellInfo) {
	                    	console.log(cellInfo);
		                    cellElement.append("<a href = '"+cellInfo.data.FileItem+"'>Download File</a>");
		                }
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
	                        url     : '<?=base_url()?>Pembelajaran/CRUD',
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