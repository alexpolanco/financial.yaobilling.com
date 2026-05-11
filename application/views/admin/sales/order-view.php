<?php
  if(!isset($_SESSION['old_id']))
  {
    $_SESSION['old_id'] = 1;
  }

  $CI =& get_instance();
  $company = $CI->get_company_data(); 
  $tabids = $CI->get_tmp_sales();
?>

<?php
// Add FIle
// include common file
  $this->load->view('admin/include/common.php'); 
// include header file
  $this->load->view('admin/include/header.php'); 
// include sidebar file  
  $this->load->view('admin/include/sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cocina 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Cocina </li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      
      <div class="col-md-6">  
      <div class="row">

        <div class="col-md-12" id="table_all" >
          <div class='box box-danger'>
            <div class="box-header">
              <h4>Mesas</h4>
            </div>
            <div class='box-body pad' id="" style="background-image:url(tabl1e/back.png); text-align:center;" >
                          
              <?php
                
                for($i = 1; $i<=$company[0]->total_table; $i++ )
                {
                  ?>
                  <a class="btn btn-app" onclick="selectBill(<?php echo $i; ?>)" style="height:140px;width:104px;white-space:normal;font-weight:700; text-align:center; <?php if($_SESSION['old_id'] == $i) echo 'background-color:red;color:#FFF;'; else if(in_array($i,$tabids)) echo 'background-color:#0073B7;color:#FFF;'; ?> " >
                    <div style="background-image:url('<?php echo base_url(); ?>file/table/<?php echo $i; ?>.png'); height: 100px;width: 90px;" ></div>
                    <label>Mesa <?php echo $i; ?></label>
                  </a>
                  
                  <?php
                  
                  if($company[0]->total_table == $i)
                  {
                    $my_table_id = $i;
                    for($j = 1; $j <= $company[0]->total_parcel; $j++ ){
                      $my_table_id++;
                      ?>
                      <a class="btn btn-app" onclick="selectBill(<?php echo $my_table_id; ?>)" style="height:140px;width:104px;white-space:normal;font-weight:700; text-align:center; <?php if($_SESSION['old_id'] == $my_table_id) echo 'background-color:red;color:#FFF;'; else if(in_array($my_table_id,$tabids)) echo 'background-color:#0073B7;color:#FFF;'; ?>  ">
                        <div style="background-image:url('<?php echo base_url(); ?>file/table/mp.png'); height: 100px;width: 90px;" ></div>
                        VIP &nbsp;<?php echo $j; ?>
                      </a>
                    <?php
                    }
                  }
                  
                }
              ?>
            </div>
          </div>
        </div>

      </div>
      </div> 

      
        <div class="col-xs-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Descripción de la orden</h3> 
              </div>
              <br />
          
              <div class='box box-info' >
                <div class='box-body pad'>
                  <div class="form-group" id="addbutton">
                    <table id="order_products"  class="table table-bordered table-hover" border='0'>
                      <thead class="bg-blue">
                          <tr id="rowheader">
                            <th align="center" width="50%">Producto</th>
                            <th align="center" width="25%">Cantidad</th>
                            <th align="center" width="25%">Valor</th> 
                          </tr>
                      </thead>
                      <tbody id="sadata">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>

      </div>
     
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <!--  Model Start -->

            
        <!--  Model End -->
        
        

  </div>
  <!-- /.content-wrapper -->

  <?php // include footer FIle

 $this->load->view('admin/include/footer.php'); ?>

<script type="text/javascript">
  
  $(function() {
    $("#bandh").click();
   });
   
   
  function selectBill(table)
  {
    var my_tab_id = table;
    $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>ajax/select_order_table_data/index",
        data: 'table_no='+ my_tab_id
    }).done(function( msg ) {
      $("#sadata").html(msg);
      $("#table_all").load(location.href+" #table_all");    
    });
    
  }
</script>