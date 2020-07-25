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
                Soal
            </header>
            <div class="panel-body">
            	<a href="<?php echo base_url() ?>soal" class="btn btn-danger"><span class="fa fa-arrow-left"> Kembali</span></a>
            	<input type="hidden" name="loadtype" id="loadtype" value="<?php echo $loadtype; ?>">
              <input type="hidden" name="topikid" id="topikid" value="<?php echo $topikid; ?>">
              <input type="hidden" name="timeticker" id="timeticker">
            	<?php 
            		if ($loadtype == 1 && $hakakes <> 3) {
            			echo '<button class="btn btn-info" id="btnAddSoal"><span class="fa fa-plus"> Tambah Soal</span></button>';
            		}
                else{
                  if ($loadtype == 2) {
                    echo '<input type="hidden" name="NISN" id="NISN" value="'.$NISN.'">';
                  }
                }
            	?>
            	<br><br><br>
              <center>
                <h2>
                  <div id="timeCD"></div>
                </h2>
              </center>
            	<div id="listSoal">
            		
            	</div>
              <div class="compose-btn">
                  <button class="btn btn-primary btn-sm" id = "_save"><i class="fa fa-check"></i> Send</button>
                  <!-- <button class="btn btn-sm"><i class="fa fa-times"></i> Reset</button> -->
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
			$.ajax({
        async :false,
        type: "post",
        url: "<?=base_url()?>Managementsoal/readtopik",
        data: {'id':topikID,topikID:''},
        dataType: "json",
        success: function (response) {
          if ($('#loadtype').val() == 1) {
            var fiveMinutes = response.data[0]['InMinutes'],
            display = document.querySelector('#timeCD');
            console.log(response.data[0]['InMinutes']);
            startTimer(fiveMinutes, display);
            console.log(display.textContent);
          }
        }
      });

			$.ajax({
              async :false,
              type: "post",
              url: "<?=base_url()?>Managementsoal/readsoal",
              data: {'id':'',topikID:topikID,'NISN':$('#NISN').val()},
              dataType: "json",
              success: function (response) {
                // bindGrid(response.data);
                // console.log($('#timeCD').html());
                var x = 1;
                var html = '';
                $.each(response.data,function (k,v) {
                  var textarea = '';
                  if ($('#loadtype').val() == 1) {
                    textarea = '<textarea class="wysihtml5 form-control" rows="5" id="jawab'+x+'"></textarea>';
                  }
                  else if ($('#loadtype').val() == 2) {
                    textarea = '<textarea class="wysihtml5 form-control" rows="5" id="jawab'+x+'" readonly>'+v.Jawaban+'</textarea>';
                  }
                  html += '<input type="hidden" name="soal'+x+'" id="soal'+x+'" value="'+v.id+'">'
                	html += '<div class="form-group">'+
                              '<label for="inputEmail1" class="col-sm-1">'+x+'. </label>'+
                                  '<h3><p class="help-block">'+v.DeskripsiSoal+'</p> </h3>'+
                          '</div>'+
                          '<div class="form-group">'+
                              '<label for="subject" class="">Jawab :</label>'+
                            '<div class="compose-editor">'+
                                textarea+
                            '</div>'+
                          '</div>';
                          if ($('#loadtype').val() == 2) {
                            html += '<div class="form-group">'+
                                    '<label for="subject" class="">Nilai : </label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="10" name = "inlineCheckbox1'+x+'"> 10'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="20" name = "inlineCheckbox1'+x+'"> 20'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="30" name = "inlineCheckbox1'+x+'"> 30'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="40" name = "inlineCheckbox1'+x+'"> 40'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="50" name = "inlineCheckbox1'+x+'"> 50'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="60" name = "inlineCheckbox1'+x+'"> 60'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="70" name = "inlineCheckbox1'+x+'"> 70'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="80" name = "inlineCheckbox1'+x+'"> 80'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="90" name = "inlineCheckbox1'+x+'"> 90'+
                                      '</label>'+
                                      '<label class="radio-inline">'+
                                          '<input type="radio" id="inlineCheckbox1'+x+'" value="100" name = "inlineCheckbox1'+x+'"> 100'+
                                      '</label>'+
                                    '</div>'
                          }
                	x += 1;
                });
                $('#listSoal').html(html);
              }
            });
		});
    window.onbeforeunload = function (e) {
      alert('A');
    };
		$('#btnAddSoal').click(function () {
			$('#modal_').modal('show');
		});
		$('.btedit').click(function () {
			// var id = $(this).attr("id");
			// GetData(id);
			alert('');
		});
    $('#_save').click(function () {
      // alert('');
      var topikID = $('#topikID').val();
      // console.log(topikID);
      var x =1;

      if ($('#loadtype').val() == 1) {
        console.log("");
        $.ajax({
          async :false,
          type: "post",
          url: "<?=base_url()?>Managementsoal/readsoal",
          data: {'id':'',topikID:topikID},
          dataType: "json",
          success : function (response) {
            if(response.success == true){
              $.ajax({
                async :false,
                type: "post",
                url: "<?=base_url()?>Managementsoal/RemoveJawab",
                data: {'topikid':topikID},
                dataType: "json",
                success : function (response2) {
                  if (response2.success == true) {
                    $.each(response.data,function (k,v) {
                      console.log($('#jawab'+x).val());
                        $.ajax({
                          async :false,
                          type    :'post',
                          url     : '<?=base_url()?>Managementsoal/CRUDJawab',
                          data    : {'SoalID':v.id,'Jawaban':$('#jawab'+x).val(),'AnswerTime' : $('#timeticker').val(),'topikid':$('#topikid').val(),'Status':0,'Score':0},
                          dataType: 'json',
                          success : function (response3) {
                            if(response3.success == true){
                              Swal.fire({
                                type: 'success',
                                title: 'Horay..',
                                text: 'Data Berhasil disimpan!',
                                // footer: '<a href>Why do I have this issue?</a>'
                              });
                            }
                            else{
                              Swal.fire({
                                type: 'error',
                                title: 'Woops...',
                                text: response3.message,
                                // footer: '<a href>Why do I have this issue?</a>'
                              });
                            }
                          }
                        });
                      x += 1;
                    });
                  }
                  else{
                    Swal.fire({
                      type: 'error',
                      title: 'Woops...',
                      text: response2.message,
                      // footer: '<a href>Why do I have this issue?</a>'
                    });
                  }
                }
              });
            }
          }
        });
      }
      else if ($('#loadtype').val() == 2) {
        var clear = false;
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Setelah koreksi, hasil nilai tidak dapat di rubah lagi, Lanjutkan ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Do it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              async :false,
              type: "post",
              url: "<?=base_url()?>Managementsoal/GetJawaban",
              data: {'NISN':$('#NISN').val(),'topikID' : $('#topikid').val()},
              dataType: "json",
              success : function (response) {
                var x = 1;
                $.each(response.data,function (k,v) {
                  console.log($("input[name='inlineCheckbox1"+x+"']:checked").val());
                  // console.log(x);
                  var Score = $("input[name='inlineCheckbox1"+x+"']:checked").val();
                  $.ajax({
                    async : false,
                    type  : "post",
                    url   : "<?=base_url()?>Managementsoal/UpdateNilai",
                    data  : {'NISN':$('#NISN').val(),'TopikID':$('#topikid').val(),'id':v.id,'point':Score},
                    success : function (response2) {
                      console.log(response2);

                    }
                  });
                  x += 1;
                });
                window.history.back();
              }
            });
          }
        })
      }
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
    function startTimer(duration, display) {
      var timer = duration, minutes, seconds;
      setInterval(function () {
          minutes = parseInt(timer / 60, 10);
          seconds = parseInt(timer % 60, 10);

          minutes = minutes < 10 ? "0" + minutes : minutes;
          seconds = seconds < 10 ? "0" + seconds : seconds;

          display.textContent = minutes + ":" + seconds;
          $('#timeticker').val(minutes + ":" + seconds);
          if (--timer < 0) {
              // timer = duration;
              Swal.fire({
                  type: 'warning',
                  title: 'Woops...',
                  text: 'Waktu Sudah Habis, Jawaban akan terposting secara Otomatis !!',
                  // footer: '<a href>Why do I have this issue?</a>'
                }).then((result)=>{
                    var topikID = $('#topikID').val();
                    var x =1;
                    $.ajax({
                      async :false,
                      type: "post",
                      url: "<?=base_url()?>Managementsoal/readsoal",
                      data: {'id':'',topikID:topikID},
                      dataType: "json",
                      success : function (response) {
                        if(response.success == true){
                          $.ajax({
                            async :false,
                            type: "post",
                            url: "<?=base_url()?>Managementsoal/RemoveJawab",
                            data: {'topikid':topikID},
                            dataType: "json",
                            success : function (response2) {
                              if (response2.success == true) {
                                $.each(response.data,function (k,v) {
                                  console.log($('#jawab'+x).val());
                                  $.ajax({
                                    async :false,
                                    type    :'post',
                                    url     : '<?=base_url()?>Managementsoal/CRUDJawab',
                                    data    : {'SoalID':v.id,'Jawaban':$('#jawab'+x).val(),'AnswerTime' : $('#timeticker').val(),'topikid':$('#topikid').val(),'Status':1},
                                    dataType: 'json',
                                    success : function (response3) {
                                      if(response3.success == true){
                                        window.location.replace("http://localhost/elearning/soal");
                                      }
                                      else{
                                        Swal.fire({
                                          type: 'error',
                                          title: 'Woops...',
                                          text: response3.message,
                                          // footer: '<a href>Why do I have this issue?</a>'
                                        });
                                      }
                                    }
                                  });
                                  x += 1;
                                });
                              }
                              else{
                                Swal.fire({
                                  type: 'error',
                                  title: 'Woops...',
                                  text: response2.message,
                                  // footer: '<a href>Why do I have this issue?</a>'
                                });
                              }
                            }
                          });
                        }
                      }
                    });
                });
          }
      }, 1000);
  }
	});
</script>