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
			      Daftar Guru
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
	                <h4 class="modal-title">Tambah Guru</h4>
	            </div>
	            <div class="modal-body">
	                <form class="form-horizontal" role="form" id="post_">
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Nomer Induk Guru</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NomorIndukGuru" name="NomorIndukGuru" placeholder="Nomer Induk Guru" required="" autocomplete="off">
	                            <input type="hidden" name="id" id="id" >
	                            <input type="hidden" name="formtype" id="formtype" value="add">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Nama Guru</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NamaGuru" name="NamaGuru" placeholder="Nama Guru" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Mata Pelajaran di Ampu</label>
	                        <div class="col-lg-8">
	                        	<input list="listMapel" name="MapelDiAmpu" id="MapelDiAmpu" class="form-control" autocomplete="off">
	                            <datalist id="listMapel" >
	                            	<?php
	                            		$rs = $this->db->query("select * from tmapel order by KodeMapel")->result();
	                            		foreach ($rs as $key) {
	                            			echo "<option value = '".$key->id." | ".$key->NamaMapel."'>";
	                            		}
	                            	?>
	                            </datalist>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Email Guru</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="Email" name="Email" placeholder="Email" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Nomor Telepon</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NoTlp" name="NoTlp" placeholder="No. Telepon" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Alamat</label>
	                        <div class="col-lg-8">
	                        	<textarea class="form-control" id="Alamat" name="Alamat" placeholder="No. Telepon" required="" autocomplete="off">
	                        	</textarea>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Tempat Lahir</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="TempatLahir" name="TempatLahir" placeholder="Tempat Lahir" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Tanggal Lahir</label>
	                        <div class="col-lg-8">
	                            <input type="date" class="form-control" id="TanggalLahir" name="TanggalLahir" placeholder="Tanggal Lahir" required="" autocomplete="off">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Agama</label>
	                        <div class="col-lg-8">
	                            <select id="Agama" name="Agama" class="form-control" required="" autocomplete="off">
	                            	<option value="Kristen">Kristen</option>
	                            	<option value="Islam">Islam</option>
	                            	<option value="Hindu">Hindu</option>
	                            	<option value="Budha">Budha</option>
	                            	<option value="Lainnya">Lainnya</option>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Jenis Kelamin</label>
	                        <div class="col-lg-8">
	                            <select id="Gender" name="Gender" class="form-control" required="" autocomplete="off">
	                            	<option value="L">Laki - Laki</option>
	                            	<option value="P">Perempuan</option>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Foto</label>
	                        <div class="col-lg-8">
	                            <input type="file" id="bannerimage" name="bannerimage" />
					              <img src="" id="profile-img-tag" width="200" />
					              <span class="help-block">Max Resolution 800 x 600</span>
					              <textarea id="image" name="image" style="display: none;"></textarea>
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
			// $('#NomorIndukGuru').attr('readonly',true);
			$.ajax({
              type: "post",
              url: "<?=base_url()?>Guru/read",
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
		$("#bannerimage").change(function(){
	      var file = $(this)[0].files[0];
	      img = new Image();
	      img.src = _URL.createObjectURL(file);
	      var imgwidth = 0;
	      var imgheight = 0;
	      img.onload = function () {
	        imgwidth = this.width;
	        imgheight = this.height;
	        $('#width').val(imgwidth);
	        $('#height').val(imgheight);
	      }
	      readURL(this);
	      encodeImagetoBase64(this);
	      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
	    });
	    $('.viewImage').click(function () {
	      var id = $(this).attr("id");
	      var table = 'sitebanner';
	      $.ajax({
	        type    :'post',
	        url     : '<?=base_url()?>Root/Apps/viewData',
	        data    : {id:id,table:table},
	        dataType: 'json',
	        success : function (response) {
	          if(response.success == true){
	            $.each(response.data,function (k,v) {
	              $('#preview-image').attr('src', v.image);
	            });
	            $('#modalViewImage').modal('show');
	          }
	        }
	      });
	    });
        $('#post_').submit(function (e) {
            $('#btn_Save').text('Tunggu Sebentar.....');
            $('#btn_Save').attr('disabled',true);

            e.preventDefault();
            var me = $(this);

            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>Guru/CRUD',
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
                },
                statusCode: {
			        500: function() {
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
        $('#NomorIndukGuru').focusout(function () {
        	var where_field = 'NomorIndukGuru';
            var where_value = $('#NomorIndukGuru').val();
            var table = 'tguru';
            $.ajax({
              type: "post",
              url: "<?=base_url()?>Guru/read",
              data: {'NomorIndukGuru':$('#NomorIndukGuru').val()},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    $('#NomorIndukGuru').val(v.NomorIndukGuru);
					$('#NamaGuru').val(v.NamaGuru);
					$('#MapelDiAmpu').val(v.KodeMapel + ' | '+v.NamaMapel).change();
					$('#Email').val(v.Email);
					$('#NoTlp').val(v.NoTlp);
					$('#Alamat').val(v.Alamat);
					$('#image').val(v.Foto);
					$('#TempatLahir').val(v.TempatLahir);
					$('#TanggalLahir').val(v.TanggalLahir);
					$('#Gender').val(v.Gender).change();
					$('#Agama').val(v.Agama).change();

                    $('#id').val(v.id);
                    $('#formtype').val("edit");

                    $('#NomorIndukGuru').attr('readonly',true);

                    img = new Image();
		            img.src = v.Foto;
		            var imgwidth = 0;
		            var imgheight = 0;
		            img.onload = function () {
		                imgwidth = this.width;
		                imgheight = this.height;
		                $('#width').val(imgwidth);
		                $('#height').val(imgheight);
		              }
                  });
              }
            });
        })
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
		    $('#image').val('');
		      var file = element.files[0];
		      var reader = new FileReader();
		      reader.onloadend = function() {
		        // $(".link").attr("href",reader.result);
		        // $(".link").text(reader.result);
		        $('#image').val(reader.result);
		      }
		      reader.readAsDataURL(file);
		  }
        function GetData(id) {
            var where_field = 'id';
            var where_value = id;
            var table = 'tguru';
            $.ajax({
              type: "post",
              url: "<?=base_url()?>Guru/read",
              data: {'id':id},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    $('#NomorIndukGuru').val(v.NomorIndukGuru);
					$('#NamaGuru').val(v.NamaGuru);
					$('#MapelDiAmpu').val(v.KodeMapel + ' | '+v.NamaMapel).change();
					$('#Email').val(v.Email);
					$('#NoTlp').val(v.NoTlp);
					$('#Alamat').val(v.Alamat);
					$('#image').val(v.Foto);
					$('#TempatLahir').val(v.TempatLahir);
					$('#TanggalLahir').val(v.TanggalLahir);
					$('#Gender').val(v.Gender).change();
					$('#Agama').val(v.Agama).change();

                    $('#id').val(v.id);
                    $('#formtype').val("edit");

                    $('#NomorIndukGuru').attr('readonly',true);

                    img = new Image();
		            img.src = v.Foto;
		            var imgwidth = 0;
		            var imgheight = 0;
		            img.onload = function () {
		                imgwidth = this.width;
		                imgheight = this.height;
		                $('#width').val(imgwidth);
		                $('#height').val(imgheight);
		              }

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
	                    dataField: "NomorIndukGuru",
	                    caption: "Nomor Induk",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaGuru",
	                    caption: "Nama Guru",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaMapel",
	                    caption: "Pengampu Mata Pelajaran",
	                    allowEditing:false
	                },
	                {
	                    dataField: "TempatLahir",
	                    caption: "Tempat Lahir",
	                    allowEditing:false
	                },
	                {
	                    dataField: "TanggalLahir",
	                    caption: "Tanggal Lahir",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Gender",
	                    caption: "Jenis Kelamin",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Agama",
	                    caption: "Agama",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NoTlp",
	                    caption: "No. Tlp",
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
	                        url     : '<?=base_url()?>Guru/CRUD',
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