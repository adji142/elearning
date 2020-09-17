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
			      Daftar Peserta Ujian / Test (<?php echo $topikname ?>)
			    </div>
			    <input type="hidden" name="topikid" id="topikid" value="<?php echo $topikid ?>">
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
              url: "<?=base_url()?>Managementsoal/GetPeserta",
              data: {'topikid':$('#topikid').val()},
              dataType: "json",
              success: function (response) {
                bindGrid(response.data);
              }
            });
		});
		$('.close').click(function() {
            location.reload();
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
		function bindGrid(data) {

	        $("#gridContainer").dxDataGrid({
	            allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "NISN",
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
	                // allowAdding:true,
	                // allowUpdating: true,
	                // allowDeleting: true,
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
	                    dataField: "Nilai",
	                    caption: "Nilai",
	                    allowEditing:false
	                },
	                {
	                    dataField: "FileItem",
	                    caption: "Action",
	                    allowEditing:false,
	                    cellTemplate: function(cellElement, cellInfo) {
	                    	var LinkAccess = "";
	                    	if (cellInfo.data.Nilai > 0) {
	                    		LinkAccess = "<span class='badge badge-primary'>Nilai Sudah Terbit</span>";
	                    	}
	                    	else{
	                    		LinkAccess = "<a href = '<?=base_url()?>koreksisoal/"+cellInfo.data.id+"/"+cellInfo.data.NISN+"' class='badge badge-primary'>Koreksi Hasil Ujian / Test</a>";
	                    	}
		                    cellElement.append(LinkAccess);
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
	                        url     : '<?=base_url()?>Siswa/CRUD',
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