<?php
  
  $CI =& get_instance();
  $check_rights = $CI->check_rights();
              
  $totaluser = $CI->total_user();
  $totalcollector = $CI->total_collector();
  $totalcustomer = $CI->total_customer();
  $totalloans = $CI->total_loans();
  $totalloansfixed = $CI->total_loansfixed();
  $totalloanscapital = $CI->total_loanscapital();
  $totalloansinversion = $CI->total_loansinversion();
  $totalloanschristmas = $CI->total_loanschristmas();
  $totalloansquickbusiness = $CI->total_loansquickbusiness();
  $totalloansdue = $CI->total_loansdue();
  $totalparty = $CI->total_party();
  $totalproduct = $CI->total_product();
  $total_bill = $CI->total_loans_no();
  
  $recored = $CI->sales();
  $order = $CI->order();
  $loans = $CI->loans();
  $loansfixed = $CI->loansfixed();
  $loanscapital = $CI->loanscapital();
  $loansinversion = $CI->loansinversion();
  $loanschristmas = $CI->loanschristmas();
  $loansquickbusiness = $CI->loansquickbusiness();
  //print_r($order);exit;
  $product = $CI->get_product();
  $customer = $CI->get_customer();

  $arpn = array();
  $arpt = array();
  $sales = $CI->get_sales_chart();
  $loans_chart = $CI->get_loans_chart();

  foreach ($loans_chart as  $row) {
    $arpn[] = $row->customer_first_name;
    //$total = $row->current_balance; 
    $arpt[] = $row->current_balance;
  }

  $salevalue = array();
  for ($i =1 ; $i<=14; $i++){
    $val = $CI->loans_month_r($i);
    $salevalue[] = intval($val);
  }
  $sv = implode(',',$salevalue); 

?>

<?php include('include/common.php'); ?>

  <?php include('include/header.php'); ?>
  
  <?php include('include/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>¡Hola, <?php echo $this->session->userdata('user'); ?>!</h1>
      <div class="breadcrumb">
      <?php 
      Class Solution {

        function isValid($s) {
          $s_strlen = count($s);
          
          if (in_array($s[0], array(')', '}', ']')))
          { return false; }

          $openBrackets = 0; $closeBrackets = 0;
          for ($i=0; $i < count($s); $i++) { 
            if (in_array($s[$i], array('(', '{', '[')))
            { $openBrackets++; }
            else 
            { $closeBrackets++; }
          }
          if ($openBrackets != $closeBrackets)
          { return false; }

          if ($s_strlen < 1 || $s_strlen > 104)
          { return false; }

          if (in_array('(',$s) || in_array(')',$s) || in_array('{',$s) || in_array('}',$s) || in_array('[',$s) || in_array(']',$s)) {
            for ($i=0; $i < count($s); $i++) { 
              $continue = false;
              if (($s[$i] == '(' && $s[$i+1] == ')') || ($s[$i] == '{' && $s[$i+1] == '}') || ($s[$i] == '[' && $s[$i+1] == ']')) {
                unset($s[$i]);
                unset($s[$i+1]);
                $k=0; $s_tmp = array();
                for ($j=0; $j < $s_strlen; $j++) {
                  if (!empty($s[$j])) {
                    $s_tmp[$k]=$s[$j];
                    $k++;
                  }
                }
                $s=$s_tmp;
                $s_strlen = count($s);

                if (!$s) 
                { return true; }
                else
                { 
                  $out = $this->isValid($s); 
                  return $out==1 ? true : false; 
                }
              }
            }            
          }
        }
      }
      
      //$s = readline();
      $s = array('{', '{', '}', '}', '[',']');
      //$s = array('(', '[', '}', ']');
      //$s = array('{', '}');
      //$s = array('a', 'a');

      $solution = new Solution();
      $output = $solution->isValid($s);
      
      //echo ($output ? 'valid' : 'invalid');
      
      ?>
      <?php 
      Class Solution2 {

        function calPoints($ops) {
          $ops_total = array();
          
          if (count($ops) <= 1 || count($ops) <= 1000)
          {  }

          for ($i=0; $i < count($ops); $i++) { 
            if ($ops[$i] == "+" && count($ops_total) > 1) {
              array_push($ops_total, ($ops_total[count($ops_total)-1] + $ops_total[count($ops_total)-2]));
            }
            else if ($ops[$i] == "D" && count($ops_total) > 0) {
              array_push($ops_total, ($ops_total[count($ops_total)-1] + $ops_total[count($ops_total)-1]));
            }
            else if ($ops[$i] == "C" && count($ops_total) > 0) {
              array_pop($ops_total);
            }
            else if (is_numeric($ops[$i]) && (int)$ops[$i] > -312 && (int)$ops[$i] < 312) {
              array_push($ops_total, $ops[$i]);
            } 
          }

          return array_sum($ops_total);
        }
      }
      
      //$ops = readline();
      //$ops = array('+', '5', '2', 'C', 'D', '5');
      $ops = array('5', '-2', '4', 'C', 'D', '9', '+', '+');
      //$ops = array('1');

      $solution = new Solution2();
      $output = $solution->calPoints($ops);
      
      //echo $output;
      
      function Reorder($arr, $k){
        $arr_tmp=array();
        for($i=0; $i<count($arr); $i++){
            $arr_tmp[$i]=$arr[$k];
              $k = ($k+1)>=count($arr) ? $k=0 : ++$k;
          }
        return $arr_tmp;
      }
      
      //print_r(Reorder($colors, 3));
      ?>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <?php if (in_array('customer/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>customer" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3><?php echo $totalcustomer; ?></h3>
                    <p>Clientes</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('loansfixed/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loansfixed" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3><?php echo $totalloansfixed; ?></h3>
                    <p>Préstamos intéres fijos</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('loanscapital/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loanscapital" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-red-active">
                  <div class="inner">
                    <h3><?php echo $totalloanscapital; ?></h3>
                    <p>Préstamos capital e interés</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('loansinversion/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loansinversion" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-blue-active">
                  <div class="inner">
                    <h3><?php echo $totalloansinversion; ?></h3>
                    <p>Préstamos de inversión</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('loanschristmas/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loanschristmas" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-orange-active">
                  <div class="inner">
                    <h3><?php echo $totalloanschristmas; ?></h3>
                    <p>Préstamos de regalía</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('loansquickbusiness/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loansquickbusiness" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-purple-active">
                  <div class="inner">
                    <h3><?php echo $totalloansquickbusiness; ?></h3>
                    <p>Préstamos rápidos</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('loans_routes/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loans" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3><?php echo $totalloans; ?></h3>
                    <p>Préstamos activos</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>loans/due" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-red-active">
                  <div class="inner">
                    <h3><?php echo $totalloansdue; ?></h3>
                    <p>Préstamos fuera de fecha</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('collector/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>collector" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-teal-active">
                  <div class="inner">
                    <h3><?php echo $totalcollector; ?></h3>
                    <p>Cobradores</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('users/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>users" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-olive">
                  <div class="inner">
                    <h3><?php echo $totaluser; ?></h3>
                    <p>Usuarios</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('products/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>product" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-aqua-active">
                  <div class="inner">
                    <h3><?php echo $totalproduct; ?></h3>
                    <p>Productos</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
            <?php if (in_array('sales/',$check_rights)) { ?>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <a href="<?php echo base_url() ?>sales" class="small-box-footer" style="text-decoration: none;">
                <div class="small-box bg-light-blue">
                  <div class="inner">
                    <h3><?php echo $total_bill; ?></h3>
                    <p>Ventas activas</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  
                </div>
              </a>
            </div><!-- ./col -->
            <?php } ?>
          </div><!-- /.row -->

      <div class="row">
            <div class="col-md-2">
        <!-- CUSTOMERS LIST -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h4 class="box-title">Nuevos Clientes</h4>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
          <?php
          foreach($customer as $_pro)
          {
            $photo = 'file/customer/'.$_pro->customer_image_1;
            $dphoto = base_url().'_template/images/default-50x50.gif';
            ?>
          <li class="item">
            <?php /*<div class="product-img">
              <img height="50" width="50" src="<?php echo (file_exists(base_url().$photo)) ? base_url().$photo : $dphoto;  ?>" alt="Imagen">
            </div> */ ?>
            <div class="product-info">
              <a class="product-title" href="<?php echo base_url() ?>customer/edit/<?php echo $_pro->customer_id; ?>"><?php echo $_pro->customer_first_name; ?></a>
              <span class="product-description">Cédula : <?php echo $_pro->customer_personalid; ?></span>
              <span class="product-description">Teléfono : <a href="tel:+<?php echo $_pro->customer_phone; ?>"><?php echo $_pro->customer_phone; ?></a></span>
            </div>
          </li><!-- /.item -->
            <?php
          }
          ?>
                    
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="<?php echo base_url() ?>customer/create" class="btn btn-info btn-flat pull-left">Nuevo</a>
                  <a href="<?php echo base_url() ?>customer" class="btn bg-yellow btn-flat pull-right">Ver todos</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
      </div>

      
      <div class="col-md-2">
        <!-- TABLE: FIJOS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Últimos Fijos</h4>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
          foreach($loansfixed as $_loans)
          {
            ?>
            <li class="item">
              <div class="product-info">
                <a class="product-title" href="<?php echo base_url() ?>loansfixed/edit/<?php echo $_loans->loans_no; ?>"><?php echo $_loans->customer_first_name; ?></a>
                <span class="product-description">Monto : <?php echo number_format($_loans->current_balance,2); ?></span>
              </div>
            </li><!-- /.item -->
              <?php
            }
            ?>
            </ul>
              
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url() ?>loansfixed/create" class="btn btn-info btn-flat pull-left">Nuevo</a>
              <a href="<?php echo base_url() ?>loansfixed" class="btn bg-green btn-flat pull-right">Ver todos</a>
            </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-2">
        <!-- TABLE: CAPITAL -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Últimos Capital</h4>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
          foreach($loanscapital as $_loans)
          {
            ?>
            <li class="item">
              <div class="product-info">
                <a class="product-title" href="<?php echo base_url() ?>loanscapital/edit/<?php echo $_loans->loans_no; ?>"><?php echo $_loans->customer_first_name; ?></a>
                <span class="product-description">Monto : <?php echo number_format($_loans->current_balance,2); ?></span>
              </div>
            </li><!-- /.item -->
              <?php
            }
            ?>
            </ul>
              
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url() ?>loanscapital/create" class="btn btn-info btn-flat pull-left">Nuevo</a>
              <a href="<?php echo base_url() ?>loanscapital" class="btn bg-red-active btn-flat pull-right">Ver todos</a>
            </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-2">
        <!-- TABLE: INVERSION -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Últimos Inversión</h4>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
          foreach($loansinversion as $_loans)
          {
            ?>
            <li class="item">
              <div class="product-info">
                <a class="product-title" href="<?php echo base_url() ?>loansinversion/edit/<?php echo $_loans->loans_no; ?>"><?php echo $_loans->customer_first_name; ?></a>
                <span class="product-description">Monto : <?php echo number_format($_loans->current_balance,2); ?></span>
              </div>
            </li><!-- /.item -->
              <?php
            }
            ?>
            </ul>
              
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url() ?>loansinversion/create" class="btn btn-info btn-flat pull-left">Nuevo</a>
              <a href="<?php echo base_url() ?>loansinversion" class="btn bg-blue-active btn-flat pull-right">Ver todos</a>
            </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-2">
        <!-- TABLE: REGALIA -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Últimos Regalía</h4>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
          foreach($loanschristmas as $_loans)
          {
            ?>
            <li class="item">
              <div class="product-info">
                <a class="product-title" href="<?php echo base_url() ?>loanschristmas/edit/<?php echo $_loans->loans_no; ?>"><?php echo $_loans->customer_first_name; ?></a>
                <span class="product-description">Monto : <?php echo number_format($_loans->current_balance,2); ?></span>
              </div>
            </li><!-- /.item -->
              <?php
            }
            ?>
            </ul>
              
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url() ?>loanschristmas/create" class="btn btn-info btn-flat pull-left">Nuevo</a>
              <a href="<?php echo base_url() ?>loanschristmas" class="btn bg-orange-active btn-flat pull-right">Ver todos</a>
            </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-2">
        <!-- TABLE: RAPIDOS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Últimos Rápidos</h4>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
          foreach($loansquickbusiness as $_loans)
          {
            ?>
            <li class="item">
              <div class="product-info">
                <a class="product-title" href="<?php echo base_url() ?>loansquickbusiness/edit/<?php echo $_loans->loans_no; ?>"><?php echo $_loans->customer_first_name; ?></a>
                <span class="product-description">Monto : <?php echo number_format($_loans->current_balance,2); ?></span>
              </div>
            </li><!-- /.item -->
              <?php
            }
            ?>
            </ul>
              
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url() ?>loansquickbusiness/create" class="btn btn-info btn-flat pull-left">Nuevo</a>
              <a href="<?php echo base_url() ?>loansquickbusiness" class="btn bg-purple-active btn-flat pull-right">Ver todos</a>
            </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include('include/footer.php'); ?>

<!-- Sparkline -->
    <script src="<?php echo base_url() ?>_template/plugins/sparkline/jquery.sparkline.min.js"></script>
 <!-- ChartJS 1.0.1 -->
    <script src="<?php echo base_url() ?>_template/plugins/chartjs/Chart.min.js"></script>

 <script>
  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------
$(function(){
  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
    datasets: [
      {
        label: "Productos",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: [<?php echo $sv ?>]
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------
  
  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = [
  
    <?php
  $a = 'abcdefghijklmnopqrstuvwxyz123456789';
    for($i =0;$i < count($arpn);$i++ )
    {
      $color;
        
        $color = substr(md5(rand()), 0, 6); 
      
      ?>
      {
        value : <?php echo $arpt[$i] ?>,
        color : "#<?php echo $color ?>",
        highlight: "#<?php echo $color ?>",
        label: "<?php echo $arpn[$i] ?>" 
      
      <?php
      echo '}';
      if(count($arpn) == $i)
      {
        echo '';
      }
      else
      {
        echo ',';
      }
    }
  
  ?>
  
  ];
  var pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=value %> :: <%=label%> "
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------

  
});


  function order_info(_orderno)
  { 
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open("<?php echo base_url() ?>report/order_info/"+_orderno,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
</script>
</body>
</html>