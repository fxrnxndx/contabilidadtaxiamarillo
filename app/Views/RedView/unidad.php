
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
       UNIDAD AGREGADO CORRECTAMENTE
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary bg-dark " data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
<!-- Modal FIN-->

<!--INICIO AGREGAR -->
<div class="card col-4 ">
      <div class="card-content">
          <div class="row row-group ">
              <div class="col-8 border-light">
                  <div class="card-body">
                    <h5 class="text-white mb-0">Nueva Unidad <span class="float-right"><i class="zmdi zmdi-account-add"></i></span></h5>
                    <div class="form-group">
            <button type="button" class="btn btn-light px-5"  onclick="add()"><i ></i>Crear</button>
           </div>
                    
                  </div>
              </div>
            
          </div>
      </div>
   </div> 
<!--FIN AGREGAR -->





 <!--INICIO DE FORMULARIO -->
 <form action="<?php  echo(base_url("Home/AgregarUnidad"));?>" method="post" accept-charset="utf-8">
 <input type="hidden"  name="idunidad" id="idunidad" value="0">
 <div class="row mt-3" id="formulario" style="display:none">
      <div class="col-lg-6">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Registrar Unidad </div>
           <hr>
        
           <div class="form-group">
            <label for="input-1">Placas</label>
            <input type="text" class="form-control" id="Placas" name="placas" placeholder="Ingresar placas" required>
           </div>
           <div class="form-group">
            <label for="input-2">Numero de unidad</label>
            <input type="text" class="form-control" id="Numunidad" name="numunidad" placeholder="Ingresar unidad" required>
           </div>
           <div class="form-group">
            <label for="input-3">Marca</label>
            <input type="text" class="form-control" id="Marca" name="marca" placeholder="Ingresar marca" required>
           </div>
            <div class="form-group">
            <label for="input-3">Modelo</label>
            <input type="text" class="form-control" id="Modelo" name="modelo" placeholder="Ingresar modelo" required>
           </div>
            <div class="form-group">
            <label for="input-3">Año</label>
            <input type="number" class="form-control" id="Ano" name="ano" placeholder="Ingresar año" required>
           </div>
           <div class="form-group ">
            <label for="input-1">Socio</label>
           <select class="form-control" name="idsocio" id="select-driver-change">
             <option value="0">Selecciona un socio</option>
            <?php if( isset($socios)): ?>     
                <?php if( $socios!=false): ?>       
                  <?php foreach ($socios->getResult() as $row): ?>
                      <option value="<?php echo $row->id_socios;?>">
                        <?php echo $row->nombre;?>  <?php echo $row->apellidos;?>
                      </option>
                  <?php endforeach ?>
                <?php endif ?>
              <?php endif ?>
         </select>
           </div>
         
           <div class="icheck-material-white"> 
            <input type="checkbox"  id="user-checkbox1" checked name="estatus"/>
            <label for="user-checkbox1">Activar / Desactivar</label>
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








<!--INICIO TABLA -->


<div class="row" >
       <div class="col-12 col-lg-12">
         <div class="card">
           <div class="card-header"><h4>Lista de supervisores</h4>
           <input class="form-control"  id="myInput" type="text" onkeypress="BuscarTexto()" placeholder="Search..">
          
             <div class="table-responsive">
             <div class="col-md-12 text-center">
              <ul class="pagination " id="myPager"></ul>
             </div>
                   <table class="table align-items-center table-flush table-borderless" id="myTableS">
                    <thead>
                     <tr>
                       <th>#</th>
                       <th>Placas</th>
                       <th>Numero de unidad</th>
                       <th>Marca</th>
                       <th>Modelo</th>
                       <th>Año</th>
                       <th>Socio</th>
                       <th>Editar</th>
                       <th>Estatus</th>
                     </tr>
                     </thead>
                     <tbody id="myTable">
                <?php if( $TodasUnidades!=false): ?>
                <?php foreach ($TodasUnidades->getResult() as $row): ?>
                      <tr>
                      <td><?php echo $row->Id_unidad; ?></td>
                      <td><?php echo $row->Placas; ?></td>
                      <td><?php echo $row->NumUnidad; ?></td>
                      <td><?php echo $row->Marca; ?></td>
                      <td> <?php echo $row->Modelo; ?></td>
                      <td><?php echo $row->ano; ?>
                      <td><?php echo $row->socionom; ?>
                      </td>
                      <td><a href="javascript:void();" onclick="editar('<?php echo $row->Placas; ?>','<?php echo $row->NumUnidad; ?>','<?php echo $row->Marca; ?>','<?php echo $row->Modelo; ?>','<?php echo $row->ano; ?>','<?php echo $row->id_socio_fk; ?>','<?php echo $row->Estatus; ?>','<?php echo $row->Id_unidad; ?>')"><i class="zmdi zmdi-brush"></i> <span>Editar</span></a>
                      </td>
                      <td><?php echo $row->Estatus; ?>
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
			toastr.warning("FAVOR DE SELECCIONAR UN SOCIO");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="2")
		 {
			toastr.success("UNIDAD AGREGADO");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="3")
		 {
			toastr.error("YA EXISTE UNIDAD CON ESOS DATOS");
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

  document.getElementById('idunidad').value="0";
  document.getElementById('Placas').readOnly=false;
   document.getElementById('Numunidad').value="";
  document.getElementById('Marca').value="";
  document.getElementById('Modelo').value="";
  document.getElementById('Ano').value="";
  document.getElementById('select-driver-change').value="0";
  document.getElementById('user-checkbox1').checked=true;
  
  var x = document.getElementById("formulario");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function editar(Placas,NumUnidad,Marca,Modelo,ano,idsocio,estatus,idunidad){

  document.getElementById('idunidad').value=idunidad;
  //document.getElementById('Placas').readOnly=true;
  document.getElementById('Placas').value=Placas;
  document.getElementById('Numunidad').value=NumUnidad;
  document.getElementById('Marca').value=Marca;
  document.getElementById('Modelo').value=Modelo;
  document.getElementById('select-driver-change').value=idsocio;
  document.getElementById('Ano').value=ano;
  document.getElementById('user-checkbox1').checked=estatus;
  if(estatus=="ACTIVADO")
  {
    document.getElementById('user-checkbox1').checked=true;
  }
  else
  {
    document.getElementById('user-checkbox1').checked=false;
  }
  document.getElementById("formulario").style.display = "block";
  window.scrollTo(0, 0);

}






</script>


