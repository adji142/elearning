<?php
    require_once(APPPATH."views/part/header.php");
    require_once(APPPATH."views/part/sidebar.php");
    // var_dump(APPPATH);
?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!-- //market-->
		<section class="panel">
            <header class="panel-heading">
                Tambah Soal
            </header>
            <div class="panel-body">
            	<a href="<?php echo base_url() ?>soal" class="btn btn-danger"><span class="fa fa-arrow-left"> Kembali</span></a>
            	<input type="hidden" name="loadtype" id="loadtype" value="<?php echo $loadtype; ?>">
            	<?php 
            		if ($loadtype == 1) {
            			echo '<button class="btn btn-info" id="btnAddSoal"><span class="fa fa-plus"> Tambah Soal</span></button>';
            		}
            	?>
            	<br><br><br>
            	<div id="listSoal">
            		
            	</div>
            </div>
        </section>
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
	                    <input type="hidden" name="topikID" id="topikID" value="<?php echo $topikid; ?>">
	                    <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Soal</label>
	                        <div class="col-lg-8">
	                        	<textarea class="form-control" id="DeskripsiSoal" name="DeskripsiSoal" required="" autocomplete="off">
	                        	</textarea>
	                        </div>
	                    </div>
	                    <textarea id="Image" name="Image" style="display: none;"></textarea>
	                    <div class="form-group">
	                        <div class="col-lg-offset-2 col-lg-10">
	                            <button class="btn btn-default" id="btn_Save" class="btn_Save">Simpan</button>
	                        </div>
	                    </div>
	                    <!-- <div class="form-group">
	                        <label for="inputEmail1" class="col-lg-4 col-sm-4 control-label">Deskripsi Lengkap</label>
	                        <div class="col-lg-8">
	                            <input type="file" id="Attachment" name="Attachment" accept=".jpg , .jpeg , .png" />
	                            <img src="" id="profile-img-tag" width="200" />
	                            <textarea id="Image" name="Image" style="display: none;"></textarea>
	                            
	                        </div>
	                    </div> -->
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
			var topikID = $('#topikID').val();
			console.log();
			$.ajax({
              type: "post",
              url: "<?=base_url()?>Managementsoal/readsoal",
              data: {'id':'',topikID:topikID},
              dataType: "json",
              success: function (response) {
                // bindGrid(response.data);
                var x = 1;
                var html = '';
                $.each(response.data,function (k,v) {
                	html += '<div class="form-group">' +
	            			'<label for="inputEmail1" class="col-sm-1">'+x+'</label>' +
	            			'<p class="help-block">'+ v.DeskripsiSoal+' '
	            	if ($('#loadtype').val() == 1 ) {
	            		html += '<button class="badge badge-warning btedit" id="'+v.id+'" onclick="GetData('+v.id+')">Edit</button>'+
		            			'<button class="badge badge-danger btdelete" id="'+v.id+'" onclick="removedata('+v.id+')">Delete</button>'
	            	}
	            	html += '</p></div>';
                	x += 1;
                });
                $('#listSoal').html(html);
              }
            });
		});
		$('#btnAddSoal').click(function () {
			$('#modal_').modal('show');
		});
		$('.btedit').click(function () {
			// var id = $(this).attr("id");
			// GetData(id);
			alert('');
		});
		$('.close').click(function() {
            location.reload();
        });
		$("#Attachment").change(function(){
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
	    $('#post_').submit(function (e) {
            $('#btn_Save').text('Tunggu Sebentar.....');
            $('#btn_Save').attr('disabled',true);

            e.preventDefault();
            var me = $(this);

            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>Managementsoal/CRUDSoal',
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
		  $('#Image').val('');
	      var file = element.files[0];
	      var reader = new FileReader();
	      reader.onloadend = function() {
	        // $(".link").attr("href",reader.result);
	        // $(".link").text(reader.result);
	        $('#Image').val(reader.result);
	      }
	      reader.readAsDataURL(file);
		}
	});
function GetData(id) {
    var where_field = 'id';
    var where_value = id;
    var table = 'tkelas';
    $.ajax({
      type: "post",
      url: "<?=base_url()?>Managementsoal/readsoal",
      data: {'id':id},
      dataType: "json",
      success: function (response) {
        $.each(response.data,function (k,v) {
            console.log(v.Waktu);
            $('#topikID').val(v.topikID);
			$('#DeskripsiSoal').val(v.DeskripsiSoal);
			$('#Image').val(v.Image);

            $('#id').val(v.id);
            $('#formtype').val("edit");

            $('#modal_').modal('show');
          });
      }
    });
}
function removedata(id) {
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
            url     : '<?=base_url()?>Managementsoal/CRUDSoal',
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
}
</script>