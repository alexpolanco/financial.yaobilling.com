<?php
// Add FIle
// include common file
$this->load->view('admin/include/common.php'); 
// include header file
  $this->load->view('admin/include/header.php'); 
// include sidebar file  
$this->load->view('admin/include/sidebar.php');

$event_type = $this->uri->segment(2);

?>
<?php setlocale(LC_MONETARY,"es_DO"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Calendario de <?php echo $event_type == "due" ? "préstamos pendientes de pago" : ($event_type == "payments" ? "pagos de préstamos" : "préstamos entregados") ?></h1>
      <div class="breadcrumb">
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar" class="fc fc-unthemed fc-ltr"></div>				
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section> 
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php // include footer FIle

$this->load->view('admin/include/footer.php'); ?>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src="https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>

<!-- fullCalendar -->
  <script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
  var time;
	var start;
	var end;
  <?php
    $var = 1;
  ?>
  
	$(function () {
	/* initialize the calendar
  -----------------------------------------------------------------*/
    $('#calendar').fullCalendar({
      header    : {
        //left  : 'prev,next today',
        //center: 'title',
        //right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'hoy',
        month: 'mes',
        week : 'semana',
        day  : 'día'
      },
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
      dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
	  	
      //Default events
	  <?php
		  for($i=0; $i<count($events); $i++) {
			$eventData[] = "{".
				"title : '".$events[$i]['customer_first_name']." ".$events[$i]['current_balance']." ".$events[$i]['loans_amount']."',". 
				"description : '<strong>Tipo de préstamo</strong>: ".$events[$i]['loans_type'] . "<br><strong>Cliente</strong>: ".$events[$i]['customer_first_name'] . "<br><strong>Balance actual</strong>: ".$events[$i]['current_balance'] . "<br><strong>". ($event_type == 'due' ? 'Monto prestado' : ($event_type == 'payments' ? 'Monto pagado' : 'Monto prestado')) ."</strong>: ".$events[$i]['loans_amount']."',".
				"start: new Date(".$events[$i]['orderYear'].",".($events[$i]['orderMonth']-1).",".$events[$i]['orderDay']."),".
				"backgroundColor : '#".$events[$i]['color']."',". 
				"borderColor: '#".$events[$i]['color'].
				"'}";
		  }
	  ?>
	  events    : [
      <?php
        /*$tp = count($events);
        for($j=$tp-1; $j > 0; $j--){
          ?>
          {
            title : "<?php echo $events[$j]['customer_first_name'] . " " .$events[$j]['current_balance'] . " " . $events[$j]['loans_amount'] ?>",
            description : "<?php echo "<strong>Cliente</strong>: ".$events[$j]['customer_first_name'] . "<br>" ."<strong>Operación</strong>: ".$events[$j]['current_balance'] . "<br>" . "<strong>Lugar</strong>: ".$events[$j]['loans_amount'] ?>",
            start: new Date(<?php echo $events[$j]['orderYear']; ?>, <?php echo $events[$j]['orderMonth']-1; ?>, <?php echo $events[$j]['orderDay']; ?>),
            backgroundColor : '#<?php echo $events[$j]['color']; ?>',
            borderColor: '#<?php echo $events[$j]['color']; ?>',
          }<?php echo (($tp > 1) ? "," : "");
        }*/
	    echo isset($eventData) ? implode(',', $eventData) : "";
      ?>
      ],
    select: function(start, end, allDay)
    {
      if(title)
      {
        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
        $.ajax({
        url:"<?php echo base_url() ?>events/fetchLoansDataByDate",
        type:"POST",
        data:{start:start, end:end},
        success:function()
        {
          calendar.fullCalendar('refetchEvents');
          alert("Added Successfully");
        }
        })
      }
    },
		eventMouseover: function(calEvent, jsEvent) {
			var tooltip = '<div class="tooltipevent" style="background:#ccc;position:absolute;padding:5px;z-index:10001;">' + calEvent.description + '</div>';
			var $tooltip = $(tooltip).appendTo('body');

			$(this).mouseover(function(e) {
				$(this).css('z-index', 10000);
				$tooltip.fadeIn('500');
				$tooltip.fadeTo('10', 1.9);
			}).mousemove(function(e) {
				$tooltip.css('top', e.pageY + 10);
				$tooltip.css('left', e.pageX + 20);
			});
		},

		eventMouseout: function(calEvent, jsEvent) {
			$(this).css('z-index', 8);
			$('.tooltipevent').remove();
		},
    })
  })
      
</script>
