<?php $this->session=session(); ?>
<input type="hidden" value=<?php echo($_SESSION['NOTIFICACION']); ?> id="notificacion">


<div class="clearfix"></div>

    <div class="content-wrapper">
      <div class="container-fluid">

<!--INICIO TIPO DE CAMBIO -->
<form action="<?php  echo(base_url("Home/TipoCambio"));?>" method="post" accept-charset="utf-8">
<div class="card col-6 ">
      <div class="card-content">
          <div class="row row-group ">
              <div class="col-10 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">Tipo de cambio 1 dolar USA a pesos MXN<span class="float-right"><i class="zmdi zmdi-attachment"></i></span></h5>
                    <div class="form-group">
                    <?php if( isset($TipoCambio)): ?>     
                <?php if( $TipoCambio!=false): ?>
                <?php foreach ($TipoCambio->getResult() as $row): ?>
                <input type="text" class="form-control"  id="tipocambio" name="tipocambio" placeholder="Tipo de cambio" disabled="true" value=" <?php echo $row->valor; ?>" required>
                  <?php endforeach ?>
                <?php endif ?>
                <?php endif ?>
                    
                     </br>
                    <button type="button" class="btn btn-light px-5"  onclick="change()" id="editar" ><i ></i>Editar</button>
                    <button type="submit" class="btn btn-light px-5" id="guardar" style="display: none" ><i ></i>Guardar</button>
                    </div>
                    
                  </div>
              </div>
            
          </div>
      </div>
   </div> 
</form>
<!--FIN TIPO DE CMABIO -->

  
    <!--Start Dashboard Content-->
    
      <div class="card mt-3">
      <div class="card-content ">
          <div class="row row-group m-0">
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                  <div class="card-body ">
                    <h5 class="text-white mb-0">
                 <?php if( isset($ViajesIngresosTTE)): ?>     
                <?php if( $ViajesIngresosTTE!=false): ?>
                <?php foreach ($ViajesIngresosTTE->getResult() as $row): ?>
                  <?php echo $row->ventas; ?>
                  <?php endforeach ?>
                <?php endif ?>
                <?php endif ?>
                  <span class="float-right"><i class="zmdi zmdi-car-taxi"></i></span></h5>
                      <div class="progress my-3" style="height:3px;">
                         <div class="progress-bar" style="width:55%"></div>
                      </div>
                    <p class="mb-0 text-white small-font">Total de viajes <span class="float-right"> <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                  </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">
                    <?php if( isset($ViajesIngresosTTE)): ?>     
                <?php if( $ViajesIngresosTTE!=false): ?>
                <?php foreach ($ViajesIngresosTTE->getResult() as $row): ?>
                  <?php echo $row->ingreso; ?>
                  <?php endforeach ?>
                <?php endif ?>
                <?php endif ?> 
                      <span class="float-right"><i class="fa fa-usd"></i></span></h5>
                      <div class="progress my-3" style="height:3px;">
                         <div class="progress-bar" style="width:55%"></div>
                      </div>
                    <p class="mb-0 text-white small-font">Total de venta <span class="float-right"> <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                  </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">
                    <?php if( isset($ViajesIngresosSAAT)): ?>     
                <?php if( $ViajesIngresosSAAT!=false): ?>
                <?php foreach ($ViajesIngresosSAAT->getResult() as $row): ?>
                  <?php echo $row->ventas; ?>
                  <?php endforeach ?>
                <?php endif ?>
                <?php endif ?>  
                    <span class="float-right"><i class="zmdi zmdi-car-taxi"></i></span></h5>
                      <div class="progress my-3" style="height:3px;">
                         <div class="progress-bar" style="width:55%"></div>
                      </div>
                    <p class="mb-0 text-white small-font">Total de viajes <span class="float-right"> <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                  </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">
                    <?php if( isset($ViajesIngresosSAAT)): ?>     
                <?php if( $ViajesIngresosSAAT!=false): ?>
                <?php foreach ($ViajesIngresosSAAT->getResult() as $row): ?>
                  <?php echo $row->ingreso; ?>
                  <?php endforeach ?>
                <?php endif ?>
                <?php endif ?>    
                    <span class="float-right"><i class="fa fa-usd"></i></span></h5>
                      <div class="progress my-3" style="height:3px;">
                         <div class="progress-bar" style="width:55%"></div>
                      </div>
                    <p class="mb-0 text-white small-font">Total de venta <span class="float-right"> <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                  </div>
              </div>
          </div>
      </div>
   </div>  
        

   <div class="row" >
       <div class="col-12 col-lg-12">
         <div class="card">
           <div class="card-header"><h4></h4>
           <img src=<?php  echo(base_url("assets/images/fondo1.png"));?> class="rounded" alt="Eniun" width="100%">
         </div>
       </div>
      </div>
   </div>


      <div class="row">
       <div class="col-12 col-lg-12">
         <div class="card">
           <div class="card-header"><h4>Venta del día</h4>
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
                <?php if( isset($VentaActual)): ?>     
                <?php if( $VentaActual!=false): ?>
                <?php foreach ($VentaActual->getResult() as $row): ?>
                      <tr>
                      <td><?php echo $row->numero_ticket; ?></td>
                      <td><?php echo $row->fecha_venta; ?></td>
                      <td><?php echo $row->empresanom; ?></td>
                      <td><?php echo $row->destino; ?></td>
                      <td><?php echo $row->descripcion; ?></td>
                      <td><?php echo $row->vendedornom; ?></td>
                      <td><?php echo $row->asignadornom; ?>/ <?php echo $row->Hora_asignado; ?></td>
                      <td> <?php echo $row->chofernom; ?></td>
                      <td><?php echo $row->tipopago; ?>
                      <td><?php echo $row->moneda; ?>
                      <td><?php echo $row->total; ?>
                      </td>
                      <td><?php echo $row->estatus; ?>
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





      <div class="row" style="display:none">
       <div class="col-12 " >
          <div class="card">
           <div class="card-header"><h4>Tabla semanal de ingresos</h4> 
             
           </div>
           <div class="card-body">
              <ul class="list-inline">
                <li class="list-inline-item"><i class="fa fa-circle mr-2 text-white"></i>Semana actual</li>
                <li class="list-inline-item"><i class="fa fa-circle mr-2 text-light"></i>Semana anterior</li>
                <input type="hidden" value=3 id='NewLunes'>
              </ul>
              <div class="chart-container-1">
                <canvas id="chart1"></canvas>
              </div>
           </div>
           
           
           
          </div>
       </div>
  
       <div class="col-12 col-lg-4 col-xl-4" style="display:none">
          <div class="card">
            
             <div class="card-body">
               <div class="chart-container-2">
                 <canvas id="chart2"></canvas>
                </div>
             </div>
             
           </div>
       </div>
      </div><!--End Row-->
      
  
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
//Revisar si la pagina ya cargo sus elementos
document.addEventListener("DOMContentLoaded", function() {
  if(document.getElementById("notificacion").value=="true")
		 {
			toastr.success("BIENVENIDO");
      
		 }
  else if(document.getElementById("notificacion").value=="1")
		 {
			toastr.success("TIPO DE CAMBIO ACTUALIZADO");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     else if(document.getElementById("notificacion").value=="2")
		 {
			toastr.warning("VALOR MINIMO 1");
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

function change()
{
  document.getElementById("tipocambio").disabled=false;
  document.getElementById("editar").style.display = "none";
  document.getElementById("guardar").style.display = "block";
}


</script>