
  <?php $this->session=session(); ?>
<input type="hidden" value=<?php echo($_SESSION['NOTIFICACION']); ?> id="notificacion">

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

 <!--Start Dashboard Content-->
<!-- Modal INICIO-->
<div class="modal fade text-dark" id="exampleModal" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark">NOTIFICACION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       DATOS GUARDADOS
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary bg-dark " data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
<!-- Modal FIN-->

<!--INICIO AGREGAR crear dos columnas una agregar y otra lista de gastos -->

<div class="card col-4 ">
      <div class="card-content">
          <div class="row row-group ">
              <div class="col-6 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">Nuevo gasto <span class="float-right"><i class="zmdi zmdi-account-add"></i></span></h5>
                    <div class="form-group">
                   <button type="button" class="btn btn-light px-5"  onclick="add()"><i ></i>Crear</button>
                   </div>
                    
                  </div>
              </div>
              <div class="col-6 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">Buscar Gasto Mensual <span class="float-right"><i class="zmdi zmdi-account-add"></i></span></h5>
                    <div class="form-group">
                   <button type="button" class="btn btn-light px-5"  onclick="buscar()"><i ></i>Buscar</button>
                   </div>
                    
                  </div>
              </div>
              
          </div>
      </div>
   </div> 
  
   
<!--FIN AGREGAR -->





 <!--INICIO DE FORMULARIO -->
 <form action="<?php  echo(base_url("Home/AgregarGasto"));?>" method="post" accept-charset="utf-8">
 <input type="hidden"  name="idgasto" id="idgasto" value="0">
 <div class="row mt-3" id="formulario" style="display:none">
      <div class="col-lg-6">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Registrar Gasto </div>
           <hr>
        
    
           <div class="form-group" id="categoriadiv">
            <label for="input-1">Categoria</label>
            <select name="categoria" id="categoria" class="form-control" required onchange="mostrarunidad()">
             <option value="">Seleccione una categoria</option>
             <option value="1">EMPRESA</option>
             <option value="2">GASTOS CHOFERES</option>
             <option value="3">GASTOS VARIOS</option>
             <option value="4">INFONAVIT</option>
             <option value="5">GASOLINA</option>
             <option value="6">IMPUESTOS CHOFERES</option>
             <option value="7">UNIFORMES</option>
            <option value="8">IMSS/OTROS</option>
              </select>
           </div>


           <div class="form-group" id="conceptodiv" style="display:block">
            <label for="input-1">Concepto</label>
            <select name="idconcepto" id="idconcepto" class="form-control" >
             <option value="">Seleccione un concepto</option>
             <?php foreach ($dataconceptos->getResult() as $row): ?>
              <option value="<?php echo $row->id_concepto; ?>"><?php echo $row->nombre; ?></option>
             <?php endforeach ?>
            </select>
           </div>
           <!--agregar descripcion -->           
           <div class="form-group">
            <label for="input-1">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control">
           </div>           
           <div class="form-group">
            <label for="input-1">Monto</label>
            <input type="number" name="monto" id="monto" class="form-control" required>
           </div>

           
           <div class="form-group" id="socio">
            <label for="input-1">Socio</label>
            <select name="socio" id="socio" class="form-control" >
             <option value="">Seleccione un socio</option>
             <?php foreach ($datasocios->getResult() as $row): ?>
              <option value="<?php echo $row->id_socios; ?>"><?php echo $row->nombre; ?> <?php echo $row->apellidos; ?></option>
             <?php endforeach ?>
            </select>
           </div> 

            <div class="form-group" id="unidad" style="display:none">
            <label for="input-1">Unidad</label>
            <select name="idunidad" id="idunidad" class="form-control" >
             <option value="">Seleccione una unidad</option>
             <?php foreach ($dataunidades->getResult() as $row): ?>
              <option value="<?php echo $row->Id_unidad; ?>">Modelo: <?php echo $row->Modelo; ?> |Placas: <?php echo $row->Placas; ?>| Unidad: <?php echo $row->NumUnidad; ?></option>
             <?php endforeach ?>
            </select>
           </div> 
         



           <div class="form-group">
            <label for="input-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
           </div>           
           
           <div class="form-group">
            <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i>Guardar</button>
           </div>
         </div>
         </div>
      </div>
</div>
</form>
<!--FIN DE FORMULARIO -->


 <!--INICIO DE FORMULARIO BUSCAR POR MES Y AÑO -->
 <form action="<?php  echo(base_url("Home/BuscarGasto"));?>" method="post" accept-charset="utf-8">
 <div class="row mt-3" id="buscar" style="display:none">
      <div class="col-lg-6">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Buscar gasto </div>
           <hr>

           <div class="form-group">
            <label for="input-1">Seleccionar mes y año</label>
            <input type="month" name="fechames" id="fecha" class="form-control" required>
           </div>           
           
           <div class="form-group">
            <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i>Buscar</button>
           </div>
         </div>
         </div>
      </div>
</div>
</form>
<!--FIN DE FORMULARIO -->







<!--INICIO TABLA -->


<div class="row" >
       <div class="col-12 col-lg-12">
         <div class="card">
           <div class="card-header"><h4>Lista de gastos del mes en curso <?php echo(date("M")); //mes con letras?> </h4>
           <input class="form-control"  id="myInput" type="text" onkeypress="BuscarTexto()" placeholder="Search..">
          
             <div class="table-responsive">
             <div class="col-md-12 text-center">
              <ul class="pagination " id="myPager"></ul>
             </div>
                   <table class="table align-items-center table-flush table-borderless" id="myTableS">
                    <thead>
                     <tr>
                       <th>#</th>
                       <th>Fecha</th>                       
                       <th>Concepto</th>
                       <th>Monto</th>
                       <th>Socio</th>
                     </tr>
                     </thead>
                     <tbody id="myTable">
                <?php if( $dataGastosMes!=false): ?>
                <?php foreach ($dataGastosMes->getResult() as $row): ?>
                      <tr>
                      <td><?php echo $row->id_gastos; ?></td>
                      <td><?php echo $row->fecha_gasto; ?></td>
                      <td><?php echo $row->conceptonombre; ?></td>
                      <td><?php echo $row->monto; ?></td>
                      <td><?php echo $row->socionombre; ?> <?php echo $row->socioapellidos; ?></td>
                      <td><a href="javascript:void();" onclick="editar('<?php echo $row->fecha_gasto; ?>','<?php echo $row->concepto; ?>','<?php echo $row->monto; ?>','<?php echo $row->socio; ?>','<?php echo $row->id_gastos; ?>')"><i class="zmdi zmdi-brush"></i> <span>Editar</span></a>
                      </td>
                     
                     </tr>
                <?php endforeach ?>
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
//Revisar si la pagina ya cargo sus elementos
document.addEventListener("DOMContentLoaded", function() {
  if(document.getElementById("notificacion").value=="1")
		 {
			toastr.warning("FAVOR DE SELECCIONAR UNA EMPRESA");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="2")
		 {
			toastr.success("CONCEPTO AGREGADO");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="3")
		 {
			toastr.error("YA EXISTE CONCEPTO CON ESOS DATOS");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="4")
		 {
			toastr.success("DATOS ACTUALIZADOS");
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


  function add() {

 
 
  document.getElementById('descripcion').value="";
  document.getElementById('monto').value="";
  document.getElementById('socio').value="";
  document.getElementById('fecha').value="";
  document.getElementById('idgasto').value="0";
 
  
  var x = document.getElementById("formulario");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function editar(fecha_gasto,concepto,monto,socio,id_gastos){

  document.getElementById('fecha').value=fecha_gasto;
  document.getElementById('idconcepto').value=concepto;
  document.getElementById('monto').value=monto;
  document.getElementById('socio').value=socio;
  document.getElementById('idgasto').value=id_gastos;
  document.getElementById("formulario").style.display = "block";
  window.scrollTo(0, 0);

}
function buscar(){

  var x = document.getElementById("buscar");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  window.scrollTo(0, 0);
}
function mostrarunidad(){

    var categoria = document.getElementById('categoria').value;
    var unidad = document.getElementById('unidad');
    var socio = document.getElementById('socio');
    var concepto = document.getElementById('conceptodiv');
    if(categoria == 8){
        unidad.style.display = "block";
        socio.style.display = "none";
        concepto.style.display = "none";
        
    }
    else if(categoria == 1){
       unidad.style.display = "none";
       socio.style.display = "none";
       concepto.style.display = "block";
        
    }
    else{
        unidad.style.display = "none";
        socio.style.display = "block";
        concepto.style.display = "block";
        
    }
}






</script>


