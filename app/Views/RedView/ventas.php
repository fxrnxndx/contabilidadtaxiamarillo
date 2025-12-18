<?php $this->session=session(); ?>
<input type="hidden" value=<?php echo($_SESSION['NOTIFICACION']); ?> id="notificacion">


<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

 <!--Start Dashboard Content-->
<!-- Modal INICIO-->
<div class="modal fade text-dark" id="changeDriverModal" tabindex="-1" role="dialog"  aria-labelledby="changeDriverModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark">Cambio de Chofer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form onsubmit="setDriver(event)">
       <p><b>Chofer actual:</b><div id="old-driver-text"></div></p>
       Cambiar por: <select name="id_driver" id="select-driver-change">
       <?php if( isset($drivers)): ?>     
                <?php if( $drivers!=false): ?>       
       <?php foreach ($drivers->getResult() as $row): ?>
                      <option value="<?php echo $row->id_chofer;?>">
                      	<?php echo $row->numero_empleado;?> | <?php echo $row->nombre;?> <?php echo $row->apellidos;?>
                      </option>
	       <?php endforeach ?>
         <?php endif ?>
                <?php endif ?>
	       </select>

       <br />
       <br />
       <button type="submit" class="btn btn-success">Cambiar</button>
       </form>
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary bg-dark " data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
<!-- Modal FIN-->
<!-- Modal INICIO-->
<div class="modal fade text-dark" id="changeEstatusModal" tabindex="-1" role="dialog"  aria-labelledby="changeDriverModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark">Cambio de Estatus</h5>
       
      </div>
      <div class="modal-body">
       <form onsubmit="setEstatus(event)">
       <p><b>Estatus actual:</b><div id="old-estatus-text"></div></p>
       Cambiar por: <select name="ticket_status" id="select-estatus-change" >
                      <option style="background-color: white"  value="CANCELADO">
                     CANCELADO
                      </option>
                      <option style="background-color: white" value="VENDIDO">
                      VENDIDO
                      </option>
	     
	       </select>
         <input type="hidden" value="" id="id_ticket" name="id_ticket"></input>
         
       </br>
       </br>
       <b>Motivo:</b>
         <input type="text" value="" id="motive" name="motive"></input>
       <br />
       <br />
       <button type="submit" class="btn btn-success">Cambiar</button>
       </form>
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary bg-dark " data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
<!-- Modal FIN-->

<!--INICIO AGREGAR -->
<form action="<?php  echo(base_url("Home/BuscarVentaEmpresa"));?>" method="post" accept-charset="utf-8">
<div class="card col-4">
      <div class="card-content">
          <div class="row row-group m-0">
          <div class="form-group ">
            <label for="input-1">Empresa</label>
            <select class="form-control" aria-label="Default select example" id="Empresa" name="empresa" required>
              <option value="1">T.T</option>
            </select>
           </div>
             
          </div>
          <div class="form-group">
            <label for="input-1">Fecha</label>
            <input type="date" class="form-control" id="Fecha" placeholder="Ingresar nombre" name="fecha" required>
           </div>
           <div class="form-group">
            <label for="input-1">Buscar venta</label>
            <button type="submit" class="btn btn-light px-10 form-control" ><i class="zmdi zmdi-flickr"></i> Buscar</button>
           </div>
      </div>
   </div>  
</form>


   

<!--FIN AGREGAR -->




<!--INICIO TABLA -->


<div class="row" >
       <div class="col-12 col-lg-12">
         <div class="card">
           <div class="card-header"><h4>Lista de ventas</h4>
           <input class="form-control"  id="myInput" type="text" onkeypress="BuscarTexto()" placeholder="Search..">
          
             <div class="table-responsive">
             <div class="col-md-12 text-center">
              <ul class="pagination " id="myPager"></ul>
             </div>
                   <table class="table align-items-center table-flush table-borderless" id="myTableS">
                    <thead>
                     <tr>
                       <th># Ticket</th>
                       <th>Fecha</th>
                       <th>Empresa</th>
                       <th>Destino</th>
                       <th>Descripcion</th>
                       <th>Vendedor</th>
                       <th>Asignador</th>
                       <th>Chofer</th>
                       <th>Tipo pago</th>
                       <th>Tipo moneda</th>
                       <th>Total</th>
                       <th>Estatus</th>
                       <th>Motivo Cancelacion</th>
                      
                     </tr>
                     </thead>
                     <tbody id="myTable">
                <?php if( isset($dataVentaEmpresa)): ?>     
                <?php if( $dataVentaEmpresa!=false): ?>
                <?php foreach ($dataVentaEmpresa->getResult() as $row): ?>
                      <tr>
                      <td><?php echo $row->numero_ticket; ?></td>
                      <td><?php echo $row->fecha_venta; ?></td>
                      <td><?php echo $row->empresanom; ?></td>
                      <td><?php echo $row->destino; ?></td>
                      <td><?php echo $row->descripcion; ?></td>
                      <td><?php echo $row->vendedornom; ?></td>
                      <td><?php echo $row->asignadornom; ?>/ <?php echo $row->Hora_asignado; ?></td>
                      <td>
                      	<div class="driver-name"><?php echo $row->chofernom; ?></div>
                     	<button class="btn btn-primary" type="button" onclick="changeDriver('<?php echo $row->id_ventas;?>',this)">Cambiar</button>
                      </td>
                      <td><?php echo $row->tipopago; ?></td>
                      <td><?php echo $row->moneda; ?></td>
                      <td><?php echo $row->total; ?>
                       <td>
                       <div class="estatus-name"><?php echo $row->estatus; ?></div>
                      <button class="btn btn-primary" type="button" onclick="changeEstatus('<?php echo $row->id_ventas;?>',this)">Cambiar</button>
                     </td>
                      <td><?php echo $row->motivo_cancelado; ?>
                      </td>
                     </tr>
                <?php endforeach ?>
                <?php endif ?>
                <?php endif ?>
                
                   </tbody></table>
                 </div>
         </div>
       </div>
      </div><!--End Row-->
 <!--FIN TABLA -->    
    

<!--INICIO DE DISEÑO -->
      <div class="row"  style="display:none">
       <div class="col-12 col-lg-4 col-xl-4">
          <div class="card">
           
           <div class="card-body">
           <input type="hidden" value=3 id='NewLunes'>
              <div class="chart-container-1">
                <canvas id="chart1"></canvas>
              </div>
           </div>
           
          </div>
       </div>
  
       <div class="col-12 col-lg-4 col-xl-4">
          <div class="card">
             
             <div class="card-body">
               <div class="chart-container-2">
                 <canvas id="chart2"></canvas>
                </div>
             </div>
            
           </div>
       </div>
      </div><!--FIN DE DISEÑO -->
      
     
        <!--End Dashboard Content-->


    

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

  </div>
  <!-- End container-fluid-->
    
   </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

   
  </div><!--End wrapper-->
	  
<script >
var currentElement = null;
var ticketId = null;
function changeDriver(id,element){
        ticketId = id;
	console.log(id,element);
	let driverNameElement = element.parentElement.getElementsByClassName("driver-name")[0];
	currentElement = driverNameElement;
	document.getElementById("old-driver-text").innerHTML = driverNameElement.innerHTML;
	$('#changeDriverModal').modal('show');
	
}
function changeEstatus(id,element){
        ticketId = id;
        document.getElementById("id_ticket").value=ticketId;
	console.log(id,element);
	let estatusNameElement = element.parentElement.getElementsByClassName("estatus-name")[0];
	currentElement = estatusNameElement;
	document.getElementById("old-estatus-text").innerHTML = estatusNameElement.innerHTML;
	$('#changeEstatusModal').modal('show');
	
}

function setEstatus(e){
	e.preventDefault();
        let formData = new FormData(e.target);
        formData.append('id_ticket', ticketId);
        formData.append('ticket_status', document.getElementById("select-estatus-change").value);
        formData.append('motive', document.getElementById("motive").value);
        
        axios.post('changeStatus', formData, {
            headers: {}
          }).then((response) => {
            console.log(response.data.name);
            currentElement.innerHTML = document.getElementById("select-estatus-change").value;
            currentElement = null;
            ticketId = null;
            toastr.success("Estatus Cambiado Con Exito");
          }, (error) => {
            toastr.error("NO FUE POSIBLE CAMBIAR EL ESTATUS");
         });
       
	$('#changeEstatusModal').modal('hide');
	return false;
}


function setDriver(e){
	e.preventDefault();
        let formData = new FormData(e.target);
        formData.append('id_sale', ticketId);
        
        axios.post('changeDriver', formData, {
            headers: {}
          }).then((response) => {
            console.log(response.data.name);
            currentElement.innerHTML = response.data.name;
            currentElement = null;
            ticketId = null;
            toastr.success("Chofer Cambiado Con Exito");
          }, (error) => {
            toastr.error("NO FUE POSIBLE CAMBIAR EL CHOFER");
         });
       
	$('#changeDriverModal').modal('hide');
	return false;
}

//Revisar si la pagina ya cargo sus elementos
document.addEventListener("DOMContentLoaded", function() {
  $('#select-driver-change').select2({
  	dropdownParent: $("#changeDriverModal")
  });
  if(document.getElementById("notificacion").value=="1")
		 {
			toastr.error("NO HAY VENTAS EN ESA FECHA");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="2")
		 {
			toastr.success("VENTAS ENCONTRADAS");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="3")
		 {
			toastr.warning("FAVOR DE SELECCIONAR UNA EMPRESA");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
    
  paginacion();
});
function paginacion()
{
  
//Paginar tabla

$.fn.pageMe = function(opts){
	  var $this = this,
		  defaults = {
			  perPage: 7,
			  showPrevNext: false,
			  hidePageNumbers: false
		  },
		  settings = $.extend(defaults, opts);
	  
	  var listElement = $this;
	  var perPage = settings.perPage; 
	  var children = listElement.children();
	  var pager = $('.pager');
	  
	  if (typeof settings.childSelector!="undefined") {
		  children = listElement.find(settings.childSelector);
	  }
	  
	  if (typeof settings.pagerSelector!="undefined") {
		  pager = $(settings.pagerSelector);
	  }
	  
	  var numItems = children.size();
	  var numPages = Math.ceil(numItems/perPage);
  
	  pager.data("curr",0);
	  
	  if (settings.showPrevNext){
		  $('<li class="page-item"><a href="#" class="prev_link page-link">ATRAS</a></li>').appendTo(pager);
	  }
	  
	  var curr = 0;
	  while(numPages > curr && (settings.hidePageNumbers==false)){
		  $('<li class="page-item"><a  class=" page-link  page_link">'+(curr+1)+'</a></li>').appendTo(pager);
		  curr++;
	  }
	  
	  if (settings.showPrevNext){
		  $('<li class="page-item"><a href="#" class="next_link page-link">SIGUIENTE</a></li>').appendTo(pager);
	  }
	  
	  pager.find('.page_link:first').addClass('active');
	  pager.find('.prev_link').hide();
	  if (numPages<=1) {
		  pager.find('.next_link').hide();
	  }
	  pager.children().eq(1).addClass("active");
	  
	  children.hide();
	  children.slice(0, perPage).show();
	  
	  pager.find('li .page_link').click(function(){
		  var clickedPage = $(this).html().valueOf()-1;
		  goTo(clickedPage,perPage);
		  return false;
	  });
	  pager.find('li .prev_link').click(function(){
		  previous();
		  return false;
	  });
	  pager.find('li .next_link').click(function(){
		  next();
		  return false;
	  });
	  
	  function previous(){
		  var goToPage = parseInt(pager.data("curr")) - 1;
		  goTo(goToPage);
	  }
	   
	  function next(){
		  goToPage = parseInt(pager.data("curr")) + 1;
		  goTo(goToPage);
	  }
	  
	  function goTo(page){
		  var startAt = page * perPage,
			  endOn = startAt + perPage;
		  
		  children.css('display','none').slice(startAt, endOn).show();
		  
		  if (page>=1) {
			  pager.find('.prev_link').show();
		  }
		  else {
			  pager.find('.prev_link').hide();
		  }
		  
		  if (page<(numPages-1)) {
			  pager.find('.next_link').show();
		  }
		  else {
			  pager.find('.next_link').hide();
		  }
		  
		  pager.data("curr",page);
		  pager.children().removeClass("active");
		  pager.children().eq(page+1).addClass("active");
	  
	  }
  };
  

  $(document).ready(function(){
	  
	$('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:15});
	  
  });
}


function BuscarTexto(){
  $(document).ready(function(){
	$("#myInput").on("keyup", function() {
    
	  var value = $(this).val().toLowerCase();
	  $("#myTableS tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  
	  });
	  if (value==""){
		window.location.reload(true)
	  }
	   
	});

  
  });
}


</script>


