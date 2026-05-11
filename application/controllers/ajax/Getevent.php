<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getevent extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
	
		?>
		<table id="gridbox_events" class="display cell-border row-border hover" style="width:100%">
			<thead>
			<tr><th>Seleccionar evento</th></tr>
			</thead>
			<tbody>
			<?php
			
            $folder = "./application/logs/";
            $files = scandir($folder);
            foreach ($files as $file) {
              $extension = pathinfo($file, PATHINFO_EXTENSION);
              if ($extension === "log") {
                $array = explode(".", $file);
                ?>
				<tr><td><?php echo  '<span id="event_'.$value.'" class="lead" onclick="setevent('.$file.')" >'.$array[0].'</span>'; ?></td></tr>
				<?php
                }
            }
              
			?>

			</tbody>
			<tfoot></tfoot>
		</table>
		<?php
	}
}

?>