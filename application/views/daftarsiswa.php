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
			      Daftar Siswa
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
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">NISN</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NISN" name="NISN" placeholder="Nomer Induk Siswa Nasional" required="">
	                            <input type="hidden" name="id" id="id" >
	                            <input type="hidden" name="formtype" id="formtype" value="add">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">NIS</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NIS" name="NIS" placeholder="Nomer Induk Siswa" required="">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Nama Siswa</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NamaSiswa" name="NamaSiswa" placeholder="Nama Siswa" required="">
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
	                            			echo "<option value = '".$key->id." | ".$key->NamaKelas."'>";
	                            		}
	                            	?>
	                            </datalist>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Tempat Lahir</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="TempatLahir" name="TempatLahir" placeholder="Tempat Lahir" required="">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Tanggal Lahir</label>
	                        <div class="col-lg-8">
	                            <input type="date" class="form-control" id="TanggalLahir" name="TanggalLahir" placeholder="Tanggal Lahir" required="">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Jenis Kelamin</label>
	                        <div class="col-lg-8">
	                            <select id="Gender" name="Gender" class="form-control" required="">
	                            	<option value="L">Laki - Laki</option>
	                            	<option value="P">Perempuan</option>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Alamat</label>
	                        <div class="col-lg-8">
	                        	<textarea class="form-control" id="Alamat" name="Alamat" placeholder="No. Telepon" required="">
	                        	</textarea>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Email</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="Email" name="Email" placeholder="Email" required="">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Nomor Telepon</label>
	                        <div class="col-lg-8">
	                            <input type="text" class="form-control" id="NoTlp" name="NoTlp" placeholder="No. Telepon" required="">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Agama</label>
	                        <div class="col-lg-8">
	                            <select id="Agama" name="Agama" class="form-control" required="">
	                            	<option value="Kristen">Kristen</option>
	                            	<option value="Islam">Islam</option>
	                            	<option value="Hindu">Hindu</option>
	                            	<option value="Budha">Budha</option>
	                            	<option value="Lainnya">Lainnya</option>
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
              url: "<?=base_url()?>siswa/read",
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
                url     : '<?=base_url()?>siswa/CRUD',
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
        $('#NISN').focusout(function () {
        	var where_field = 'NISN';
            var where_value = $('#NISN').val();
            var table = 'tsiswa';
            $.ajax({
              type: "post",
              url: "<?=base_url()?>siswa/read",
              data: {'NISN':$('#NISN').val()},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    $('#NISN').val(v.NISN);
                    $('#NIS').val(v.NIS);
					$('#NamaSiswa').val(v.NamaSiswa);
					$('#KelasID').val(v.KodeKelas + ' | '+v.NamaKelas).change();
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

                    $('#NISN').attr('readonly',true);

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
              url: "<?=base_url()?>siswa/read",
              data: {'id':id},
              dataType: "json",
              success: function (response) {
                $.each(response.data,function (k,v) {
                    $('#NISN').val(v.NISN);
                    $('#NIS').val(v.NIS);
					$('#NamaSiswa').val(v.NamaSiswa);
					$('#KelasID').val(v.KodeKelas + ' | '+v.NamaKelas).change();
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

                    $('#NISN').attr('readonly',true);

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
                $('#modal_').modal('show');
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
	                    dataField: "NISN",
	                    caption: "Nomor Induk Siswa Nasional",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NIS",
	                    caption: "Nomor Induk Siswa",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaSiswa",
	                    caption: "Nama Siswa",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaKelas",
	                    caption: "Kelas",
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
	                        url     : '<?=base_url()?>siswa/CRUD',
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