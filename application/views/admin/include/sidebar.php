<?php 
$CI =& get_instance();
$check_rights = $CI->check_rights();

$events_loans = $CI->getTotalEventsLoans();
$events_payments = $CI->getTotalEventsPayments();
$events_loans_due = $CI->getTotalEventsLoansDue();

//var_dump($events_loans);

$page_name = $this->uri->segment(1);
?>
<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar" style="bottom: 0; float: none; left: 0; position: fixed;top: 0;">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php /* <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url() ?>_template/dist/img/user.png" class="img-circle" alt="User Image">
            </div> 
            <div class="pull-left info">
              <p><?php echo $this->session->userdata('user'); ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          */ ?>
          <ul class="sidebar-menu">
            <li class="header">MENÚ PRINCIPAL</li>
            <?php
            if($this->uri->segment(1, 0) == TRUE && $this->uri->segment(1, 0) != "welcome") {
            ?>
            <li class="treeview">
              <a href="#!" onclick="history.back()">
                <i class="fa fa-long-arrow-left"></i> <span>Regresar</span>
              </a>
            </li>
            <?php } ?>
            <li <?php if($page_name == '') echo 'class="active"'; ?> >
              <a href="<?php echo base_url() ?>">
                <i class="fa fa-th-large"></i> <span>Dashboard</span>
              </a>
            </li>
            
            <li class="treeview <?php if($page_name == 'events') echo 'active'; ?>">
              <a href="#"><i class="fa fa-bell-o"></i><span>Calendario</span><!-- <span class="pull-right-container">
              <small class="label pull-right bg-blue"><?php //echo $events_loans ?></small>
              <small class="label pull-right bg-blue"><?php //echo $events_payments ?></small>
              <small class="label pull-right bg-blue"><?php //echo $events_loans_due ?></small>
            </span> --><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url() ?>events"><i class="fa fa-angle-double-right"></i>Prestamos<span class="pull-right-container"><small class="label pull-right bg-blue"><?php //echo $events_loans ?></small></span></a>
                  <a href="<?php echo base_url() ?>events/payments"><i class="fa fa-angle-double-right"></i>Abonos<small class="label pull-right bg-blue"><?php //echo $events_payments ?></small></a>
                  <a href="<?php echo base_url() ?>events/due"><i class="fa fa-angle-double-right"></i>Pendientes<small class="label pull-right bg-blue"><?php //echo $events_loans_due ?></small></a>
                </li>
              </ul>
            </li>
            <?php
            if($this->session->userdata('userid') == 1)
            {
          ?>
          <li class="treeview <?php if($page_name == 'customer') echo 'active'; ?>">
            <a href="#"><i class="fa fa-user"></i><span>Clientes</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li>
                <a href="<?php echo base_url() ?>customer"><i class="fa fa-angle-double-right"></i>Clientes</a>
                <a href="<?php echo base_url() ?>customer/create"><i class="fa fa-angle-double-right"></i>Nuevo Cliente</a>
              </li>
            </ul>
          </li>
            <li class="treeview <?php if($page_name == 'guarantor') echo 'active'; ?>">
              <a href="#"><i class="fa fa-male"></i><span>Garantes</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url() ?>guarantor"><i class="fa fa-angle-double-right"></i>Garantes</a>
                  <a href="<?php echo base_url() ?>guarantor/create"><i class="fa fa-angle-double-right"></i>Nuevo Garante</a>
                </li>
              </ul>
            </li>

            <li class="treeview <?php if($page_name == 'loans_routes') echo 'active'; ?>">
              <a href="#"><i class="fa fa-money"></i><span>Préstamos</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>loans"><i class="fa fa-angle-double-right"></i>Préstamo</a></li>
                <li><a href="<?php echo base_url() ?>loans/create"><i class="fa fa-angle-double-right"></i>Nuevo Préstamo</a></li>
                <li><a href="<?php echo base_url() ?>loans/due"><i class="fa fa-angle-double-right"></i>Fuera de fecha</a></li>
                <li><a href="<?php echo base_url() ?>loans/receipt"><i class="fa fa-angle-double-right"></i>Recibos</a></li>
                <li><a href="<?php echo base_url() ?>loans/return_sales"><i class="fa fa-angle-double-right"></i>Cancelar Préstamo</a></li>
                <li><a href="<?php echo base_url() ?>loans/order_view"><i class="fa fa-angle-double-right"></i>Vista previa</a></li>
              </ul>
            </li>
            
            <li class="treeview <?php if(
                  $page_name == 'opposition' //||
                  //$page_name == 'loansfixed' 
                  ) echo 'active'; ?>">
              <a href="#"><i class="fa fa-balance-scale"></i><span>Oposiciones</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url() ?>opposition"><i class="fa fa-angle-double-right"></i>Oposición</a>
                  <a href="<?php echo base_url() ?>opposition/create"><i class="fa fa-angle-double-right"></i>Nueva Oposición</a>
                </li>
              </ul>
            </li>

            <li class="treeview <?php if($page_name == 'collector') echo 'active'; ?>">
              <a href="#"><i class="fa fa-user-secret"></i><span>Cobradores</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url() ?>collector"><i class="fa fa-angle-double-right"></i>Cobradores</a>
                  <a href="<?php echo base_url() ?>collector/create"><i class="fa fa-angle-double-right"></i>Nuevo Cobrador</a>
                </li>
              </ul>
            </li>

            <li  class="treeview <?php if($page_name == 'category') echo 'active'; ?>" >
              <a href="#"><i class="fa fa-database"></i><span>Categorías</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>category"><i class="fa fa-angle-double-right"></i>Categorías</a></li>
                <li><a href="<?php echo base_url() ?>category/create"><i class="fa fa-angle-double-right"></i>Nueva Categoría</a></li>
              </ul>
            </li>
            <li class="treeview <?php if($page_name == 'product' || $page_name == 'options') echo 'active'; ?>">
              <a href="#"><i class="fa fa-cubes"></i><span>Productos</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>product"><i class="fa fa-angle-double-right"></i>Productos</a></li>
                <li><a href="<?php echo base_url() ?>product/create"><i class="fa fa-angle-double-right"></i>Nuevo Producto</a></li>
                <li><a href="<?php echo base_url() ?>options"><i class="fa fa-angle-double-right"></i>Atributos</a></li>
                <li><a href="<?php echo base_url() ?>options/create"><i class="fa fa-angle-double-right"></i>Nuevo Atributo</a></li>
              </ul>
            </li>
            

            <li class="treeview <?php if($page_name == 'sales') echo 'active'; ?>">
              <a href="#"><i class="fa fa-calendar-check-o"></i><span>Ventas</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>sales"><i class="fa fa-angle-double-right"></i>Ventas</a></li>
                <li><a href="<?php echo base_url() ?>sales/create"><i class="fa fa-angle-double-right"></i>Nueva Venta</a></li>
                <li><a href="<?php echo base_url() ?>sales/return_sales"><i class="fa fa-angle-double-right"></i>Devolución de Venta</a></li>
                <li><a href="<?php echo base_url() ?>sales/order_view"><i class="fa fa-angle-double-right"></i>Cocina</a></li>
              </ul>
            </li>

            <li class="treeview <?php if($page_name == 'expense') echo 'active'; ?>">
                <a href="<?php echo base_url() ?>expense"><i class="fa fa-gg"></i><span>Gastos</span><i class="fa fa-angle-left pull-right"></i></a>
            </li>

            <li class="treeview <?php if($page_name == 'report') echo 'active'; ?>">
              <a href="#"><i class="fa fa-table"></i><span>Reportes</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>report/customers"><i class="fa fa-angle-double-right"></i>Clientes</a></li>
                <li><a href="<?php echo base_url() ?>report"><i class="fa fa-angle-double-right"></i>Reporte general</a></li>
                <li><a href="<?php echo base_url() ?>report/report_info"><i class="fa fa-angle-double-right"></i>Reporte general de pagos</a></li>
                <li><a href="<?php echo base_url() ?>report/report_payments"><i class="fa fa-angle-double-right"></i>Reporte de pagos</a></li>
              </ul>
            </li>
             
            <li class="treeview <?php if($page_name == 'users_group' || $page_name == 'users' ) echo 'active'; ?>">
              <a href="#">
                <i class="fa fa-sitemap"></i> <span>Usuarios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($page_name == 'users_group') echo 'active'; ?> >
                  <a href="<?php echo base_url() ?>users_group"><i class="fa fa-tasks"></i>Roles</a>
                </li>
                <li <?php if($page_name == 'users') echo 'active'; ?>>
                  <a href="#"><i class="fa fa-user-md"></i>Usuarios<i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>users"><i class="fa fa-angle-double-right"></i>Usuarios</a></li>
                    <li><a href="<?php echo base_url() ?>users/create"><i class="fa fa-angle-double-right"></i>Nuevo usuario</a></li>
                  </ul>
                </li>
                
              </ul>
            </li>
              
              <li class="treeview <?php if($page_name == 'district' || $page_name == 'cities') echo 'active'; ?>">
                <a href="#"><i class="fa fa-map-pin"></i><span>Ubicación</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="treeview <?php if($page_name == 'district') echo 'active'; ?>">
                        <a href="<?php echo base_url() ?>district/"><i class="fa fa-cog"></i><span>Provincias</span></a>
                    </li>
                    <li class="treeview <?php if($page_name == 'cities') echo 'active'; ?>">
                        <a href="<?php echo base_url() ?>cities/"><i class="fa fa-cog"></i><span>Ciudades</span></a>
                    </li>
                </ul>
              </li>

            <li class="treeview <?php if($page_name == 'routes/') echo 'active'; ?>">
              <a href="<?php echo base_url() ?>routes"><i class="fa fa-map-signs"></i><span>Rutas</span></a>
            </li>

            <li class="treeview <?php if($page_name == 'loanstype/') echo 'active'; ?>">
              <a href="<?php echo base_url() ?>loanstype"><i class="fa fa-cog"></i><span>Tipos de préstamos</span></a>
            </li>
            
            <li class="treeview <?php if($page_name == 'company/') echo 'active'; ?>">
              <a href="<?php echo base_url() ?>company/edit"><i class="fa fa-building"></i><span>La Empresa</span></a>
            </li>
          <?php 
                
            } 
            else
            {
              ?>
              <?php if (in_array('customer/',$check_rights) || in_array('customer/create',$check_rights)) { ?>
                <li class="treeview <?php if($page_name == 'customer') echo 'active'; ?>">
                  <a href="#"><i class="fa fa-user"></i><span>Clientes</span><i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li>
                    <?php if(in_array('customer/', $check_rights)) { ?>
                        <a href="<?php echo base_url() ?>customer"><i class="fa fa-angle-double-right"></i>Clientes</a>
                    <?php }
                    if(in_array('customer/create', $check_rights))
                    {
                    ?>
                        <a href="<?php echo base_url() ?>customer/create"><i class="fa fa-angle-double-right"></i>Nuevo Cliente</a>
                    <?php } ?>
                    </li>
                  </ul>
                </li>
              <?php } ?>
              <?php if (in_array('guarantor/',$check_rights) || in_array('guarantor/create',$check_rights)) { ?>
                <li class="treeview <?php if($page_name == 'guarantor') echo 'active'; ?>">
                  <a href="#"><i class="fa fa-male"></i><span>Garantes</span><i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li>
                    <?php if(in_array('guarantor/', $check_rights)) { ?>
                        <a href="<?php echo base_url() ?>guarantor"><i class="fa fa-angle-double-right"></i>Garante</a>
                    <?php }
                    if(in_array('guarantor/create', $check_rights))
                    {
                    ?>
                        <a href="<?php echo base_url() ?>guarantor/create"><i class="fa fa-angle-double-right"></i>Nuevo Garante</a>
                    <?php } ?>
                    </li>
                  </ul>
                </li>
              <?php } ?>

              <?php if (
              in_array('loans_routes/',$check_rights) || 
              in_array('loansfixed/',$check_rights) || 
              in_array('loanscapital/',$check_rights) || 
              in_array('loanschristmas/',$check_rights) || 
              in_array('loansinversion/',$check_rights) || 
              in_array('loansquickbusiness/',$check_rights)
              ) { ?>
                  <li class="treeview <?php if(
                  $page_name == 'loans_routes' ||
                  $page_name == 'loansfixed' ||
                  $page_name == 'loanscapital' ||
                  $page_name == 'loanschristmas' ||
                  $page_name == 'loansinversion' ||
                  $page_name == 'loansquickbusiness'
                  ) echo 'active'; ?>">
                  <a href="#"><i class="fa fa-money"></i><span>Préstamos</span><i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <?php if(in_array('loans_routes/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>loans"><i class="fa fa-angle-double-right"></i>Préstamo</a></li>
                    <li><a href="<?php echo base_url() ?>loans/create"><i class="fa fa-angle-double-right"></i>Nuevo Préstamo</a></li>
                    <li><a href="<?php echo base_url() ?>loans/due"><i class="fa fa-angle-double-right"></i>Fuera de fecha</a></li>
                    
                    <li><a href="<?php echo base_url() ?>loans/receipt"><i class="fa fa-angle-double-right"></i>Recibos</a></li>
                    
                    <li><a href="<?php echo base_url() ?>loans/return_sales"><i class="fa fa-angle-double-right"></i>Cancelar Préstamo</a></li>
                    
                    <li><a href="<?php echo base_url() ?>loans/order_view"><i class="fa fa-angle-double-right"></i>Vista previa</a></li>
                    <?php } ?>
                    <?php if(in_array('loansfixed/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>loansfixed"><i class="fa fa-angle-double-right"></i>Intéres fijo</a></li>
                    <?php } ?>
                    <?php if(in_array('loanscapital/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>loanscapital"><i class="fa fa-angle-double-right"></i>Capital e intéres</a></li>
                    <?php } ?>
                    <?php if(in_array('loanschristmas/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>loanschristmas"><i class="fa fa-angle-double-right"></i>Regalía navideña</a></li>
                    <?php } ?>
                    <?php if(in_array('loansinversion/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>loansinversion"><i class="fa fa-angle-double-right"></i>Inversión</a></li>
                    <?php } ?>
                    <?php if(in_array('loansquickbusiness/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>loansquickbusiness"><i class="fa fa-angle-double-right"></i>Préstamos rápidos</a></li>
                    <?php } ?>
                  </ul>
                </li>
                  
              <li class="treeview <?php if(
                    $page_name == 'opposition'
                    ) echo 'active'; ?>">
                <a href="#"><i class="fa fa-balance-scale"></i><span>Oposiciones</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li>
                    <a href="<?php echo base_url() ?>opposition"><i class="fa fa-angle-double-right"></i>Oposición</a>
                    <a href="<?php echo base_url() ?>opposition/create"><i class="fa fa-angle-double-right"></i>Nueva Oposición</a>
                  </li>
                </ul>
              </li>
              <?php } ?>
              
              <?php if (in_array('category/',$check_rights) || in_array('category/create',$check_rights)) { ?>
              <li  class="treeview <?php if($page_name == 'category') echo 'active'; ?>" >
                <a href="#"><i class="fa fa-database"></i><span>Categorías</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php if(in_array('category/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>category"><i class="fa fa-angle-double-right"></i>Categorías</a></li>
                  <?php }
                    if(in_array('category/create', $check_rights))
                    {
                  ?>
                    <li><a href="<?php echo base_url() ?>category/create"><i class="fa fa-angle-double-right"></i>Nueva Categoría</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php } ?>

              <?php if (in_array('product/',$check_rights) || in_array('options/create',$check_rights) || in_array('options/',$check_rights) || in_array('options/create',$check_rights)) { ?>
              <li class="treeview <?php if($page_name == 'product' || $page_name == 'options') echo 'active'; ?>">
                <a href="#"><i class="fa fa-cubes"></i><span>Productos</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php if(in_array('product/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>product"><i class="fa fa-angle-double-right"></i>Productos</a></li>
                  <?php }
                    if(in_array('product/create', $check_rights))
                    {
                  ?>
                    <li><a href="<?php echo base_url() ?>product/create"><i class="fa fa-angle-double-right"></i>Nuevo Producto</a></li>
                  <?php } ?>
                  <?php if(in_array('options/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>options"><i class="fa fa-angle-double-right"></i>Atributos</a></li>
                  <?php }
                    if(in_array('options/create', $check_rights))
                    {
                  ?>
                    <li><a href="<?php echo base_url() ?>options/create"><i class="fa fa-angle-double-right"></i>Nuevo Atributo</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php } ?>

              <?php if (in_array('collector/',$check_rights)) { ?>
            <li class="treeview <?php if($page_name == 'collector') echo 'active'; ?>">
              <a href="#"><i class="fa fa-user-secret"></i><span>Cobradores</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url() ?>collector"><i class="fa fa-angle-double-right"></i>Cobradores</a>
                  <a href="<?php echo base_url() ?>collector/create"><i class="fa fa-angle-double-right"></i>Nuevo Cobrador</a>
                </li>
              </ul>
            </li>
              <?php } ?>

              <?php if (in_array('sales/',$check_rights)) { ?>
              <li class="treeview <?php if($page_name == 'sales') echo 'active'; ?>">
                <a href="#"><i class="fa fa-calendar-check-o"></i><span>Ventas</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php if(in_array('sales/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>sales"><i class="fa fa-angle-double-right"></i>Ventas</a></li>
                  <?php }
                    if(in_array('sales/create', $check_rights))
                    {
                  ?>
                    <li><a href="<?php echo base_url() ?>sales/create"><i class="fa fa-angle-double-right"></i>Nueva Venta</a></li>
                  <?php }
                    if(in_array('sales/return_sales', $check_rights))
                    {
                  ?>
                    <li><a href="<?php echo base_url() ?>sales/return_sales"><i class="fa fa-angle-double-right"></i>Devolución de Ventas</a></li>
                  <?php } 
                    if(in_array('sales/order-view', $check_rights))
                    {
                  ?>
                    <li><a href="<?php echo base_url() ?>sales/order_view"><i class="fa fa-angle-double-right"></i>Cocina</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php } ?>

              <?php if (in_array('expense/',$check_rights)) { ?>
              <li class="treeview <?php if($page_name == 'expense') echo 'active'; ?>">
                <a href="<?php echo base_url() ?>expense"><i class="fa fa-gg"></i><span>Gastos</span><i class="fa fa-angle-left pull-right"></i></a>
              </li>
              <?php } ?>
              
              <?php if (in_array('report/',$check_rights) || in_array('report/table',$check_rights)) { ?>
              <li class="treeview <?php if($page_name == 'report') echo 'active'; ?>">
                <a href="#"><i class="fa fa-table"></i><span>Reportes</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() ?>report/customers"><i class="fa fa-angle-double-right"></i>Clientes</a></li>
                  <?php if(in_array('report/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>report"><i class="fa fa-angle-double-right"></i>Reporte general</a></li>
                    <li><a href="<?php echo base_url() ?>report/report_cashflow"><i class="fa fa-angle-double-right"></i>Cashflow</a></li>
                    <li><a href="<?php echo base_url() ?>report/report_loans"><i class="fa fa-angle-double-right"></i>Reporte de prestamos</a></li>
                    <li><a href="<?php echo base_url() ?>report/report_info"><i class="fa fa-angle-double-right"></i>Reporte general de pagos</a></li>
                    <li><a href="<?php echo base_url() ?>report/report_payments"><i class="fa fa-angle-double-right"></i>Reporte de pagos</a></li>
                    <li><a href="<?php echo base_url() ?>report/report_earnings"><i class="fa fa-angle-double-right"></i>Egresos/Ingresos</a></li>
                  <?php } ?>
                  <?php if(in_array('expense/', $check_rights)) { ?>
                    <li><a href="<?php echo base_url() ?>report/expense"><i class="fa fa-angle-double-right"></i>Gastos</a></li>
                  <?php } ?>
                  <li><a href="<?php echo base_url() ?>report/logs"><i class="fa fa-angle-double-right"></i>Eventos</a></li>
                </ul>
              </li>
              <?php } ?>
              
              <?php if (in_array('district/',$check_rights) || in_array('cities',$check_rights)) { ?>
              <li class="treeview <?php if($page_name == 'district' || $page_name == 'cities') echo 'active'; ?>">
                <a href="#"><i class="fa fa-table"></i><span>Ubicación</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php if(in_array('district/', $check_rights)) { ?>
                    <li class="treeview <?php if($page_name == 'district') echo 'active'; ?>">
                        <a href="<?php echo base_url() ?>district/"><i class="fa fa-cog"></i><span>Provincias</span></a>
                      </li>
                  <?php }
                    if(in_array('cities', $check_rights))
                    {
                  ?>
                    <li class="treeview <?php if($page_name == 'cities') echo 'active'; ?>">
                        <a href="<?php echo base_url() ?>cities/"><i class="fa fa-cog"></i><span>Ciudades</span></a>
                      </li>
                  <?php } ?>
                </ul>
              </li>
              <?php } ?>
              
              <?php if (in_array('routes/',$check_rights)) { ?>
            <li class="treeview <?php if($page_name == 'routes') echo 'active'; ?>">
              <a href="<?php echo base_url() ?>routes"><i class="fa fa-map-signs"></i><span>Rutas</span></a>
            </li>
              <?php } ?>

              <?php if (in_array('loanstype/',$check_rights)) { ?>
            <li class="treeview <?php if($page_name == 'loanstype') echo 'active'; ?>">
              <a href="<?php echo base_url() ?>loanstype"><i class="fa fa-cog"></i><span>Tipos de préstamos</span></a>
            </li>
              <?php } ?>
              
              <?php if (in_array('company/edit',$check_rights)) { ?>
              <li class="treeview <?php if($page_name == 'company') echo 'active'; ?>">
                <a href="<?php echo base_url() ?>company/edit"><i class="fa fa-building"></i><span>La Empresa</span></a>
              </li>
              <?php } ?>

              <?php
            }
          ?>  
<!--
          <li class="treeview <?php //if($page_name == 'company/') echo 'active'; ?>">
            <a href="<?php echo base_url() ?>iframe/datacredito" title="Sitio web externo"><i class="fa fa-bar-chart"></i><span>Datacrédito</span></a>
          </li>
          <li class="treeview <?php //if($page_name == 'company/') echo 'active'; ?>">
            <a href="<?php echo base_url() ?>iframe/transunion" title="Sitio web externo"><i class="fa fa-bar-chart"></i><span>Transunión</span></a>
          </li>
          <li class="treeview <?php //if($page_name == 'company/') echo 'active'; ?>">
            <a href="<?php echo base_url() ?>iframe/gmail" title="Sitio web externo"><i class="fa fa-envelope"></i><span>Gmail</span></a>
          </li>
-->
          <li class="treeview">
            <a href="<?php echo base_url().'login/logout' ?>"><i class="fa fa-sign-out" aria-hidden="true""></i><span>Cerrar sesión</span></a>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
