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
       VENDEDOR AGREGADO CORRECTAMENTE
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
                    <h5 class="text-white mb-0">Nuevo vendedor <span class="float-right"><i class="zmdi zmdi-account-add"></i></span></h5>
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
 <form action="<?php  echo(base_url("Home/AgregarVendedor"));?>" method="post" accept-charset="utf-8">
 <input type="hidden"  name="idvendedor" id="idvendedor" value="0">
<div id="formulario"  style="display:none">
 <div class="row mt-3" >
      <div class="col-lg-6">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Registrar Perfil </div>
           <hr>
        
           <div class="form-group">
            <label for="input-1">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="nombre" placeholder="Ingresar nombre" required>
           </div>
           <div class="form-group">
            <label for="input-2">Apellidos</label>
            <input type="text" class="form-control" id="Apellidos" name="apellidos" placeholder="Ingresar apellidos" required>
           </div>
           <div class="form-group">
            <label for="input-3">Numero de telefono</label>
            <input type="text" class="form-control" id="Telefono" name="telefono" placeholder="Ingresar numero de telefono con lada" required>
           </div>
           <div class="form-group ">
            <label for="input-1">Empresa</label>
            <select class="form-control" aria-label="Default select example" id="Empresa" name="empresa" required>
              <option selected value="0">Seleccione una empresa</option>
              <option value="1">T.T.E</option>
              <option value="2">S.A.A.T</option>
            </select>
           </div>
           <div class="form-group">
            <label for="input-1">Porcentaje de ganancia de los viajes</label>
            <input type="number" step="0.1" class="form-control" id="Porcentaje" placeholder="Ingresar porcentaje" name="ganancia" required>
           </div>
           <div class="icheck-material-white">
           
            <input type="checkbox"  id="user-checkbox1" checked name="estatus"/>
            <label for="user-checkbox1">Activar / Desactivar</label>
            </div>
         </div>
         </div>
      </div>

      <div class="col-lg-6">
       <div class="card">
         <div class="card-body">
         <div class="card-title">Crear usuario</div>
         <hr>
          
         <div class="form-group">
          <label for="input-1">Usuario</label>
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Enter Your Name" required>
         </div>
         <div class="form-group">
          <label for="input-4">Password</label>
          <input type="text" class="form-control" id="contra" name="contra" placeholder="Enter Password" required>
         </div>
         <div class="form-group">
          <label for="input-5">Confirm Password</label>
          <input type="text" class="form-control" id="contra2" name="contra2" placeholder="Confirm Password" required>
         </div>
        
         <div class="form-group">
          <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i>Guardar</button>
         </div>
       
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
           <div class="card-header"><h4>Lista de vendedores</h4>
           <input class="form-control"  id="myInput" type="text" onkeypress="BuscarTexto()" placeholder="Search..">
          
             <div class="table-responsive">
             <div class="col-md-12 text-center">
              <ul class="pagination " id="myPager"></ul>
             </div>
                   <table class="table align-items-center table-flush table-borderless" id="myTableS">
                    <thead>
                     <tr>
                       <th>#</th>
                       <th>Nombre</th>
                       <th>Usuario</th>
                       <th>Telefono</th>
                       <th>Empresa</th>
                       <th>Porcentaje</th>
                       <th>Editar</th>
                       <th>Estatus</th>
                     </tr>
                     </thead>
                     <tbody id="myTable">
                <?php if( $TodosVendedores!=false): ?>
                <?php foreach ($TodosVendedores->getResult() as $row): ?>
                      <tr>
                      <td><?php echo $row->id_vendedor; ?></td>
                      <td><?php echo $row->nombre; ?></td>
                      <td><?php echo $row->usuario; ?></td>
                      <td><?php echo $row->telefono; ?></td>
                      <td> <?php echo $row->empresanom; ?></td>
                      <td><?php echo $row->porcentaje_ganancia; ?>
                      </td>
                      <td><a href="javascript:void();" onclick="editar('<?php echo $row->nombre; ?>','<?php echo $row->apellidos; ?>','<?php echo $row->telefono; ?>','<?php echo $row->id_empresa_fk; ?>','<?php echo $row->porcentaje_ganancia; ?>','<?php echo $row->estatus; ?>','<?php echo $row->id_vendedor; ?>','<?php echo $row->usuario; ?>','<?php echo $row->contra; ?>')"><i class="zmdi zmdi-brush"></i> <span>Editar</span></a>
                      </td>
                      <td><?php echo $row->estatus; ?>
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
			toastr.success("VENDEDOR AGREGADO");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="3")
		 {
			toastr.error("YA EXISTE VENDEDOR CON ESOS DATOS");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="4")
		 {
			toastr.success("DATOS ACTUALIZADOS");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="5")
		 {
			toastr.warning("LAS CONTRASEÑAS SON DIFERENTES");
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
 
  document.getElementById('idvendedor').value="0";
  document.getElementById('Nombre').value="";
  document.getElementById('Apellidos').value="";
  document.getElementById('Telefono').value="";
  document.getElementById('Telefono').readOnly=false;
  document.getElementById('Empresa').value="0";
  document.getElementById('Porcentaje').value="";
  document.getElementById('user-checkbox1').checked=true;
  document.getElementById('usuario').value="";
  document.getElementById('usuario').readOnly=false;
  document.getElementById('contra').value="";
  document.getElementById('contra2').value="";
  
    var x = document.getElementById("formulario");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

}

function editar(Nombre,Apellidos,Telefono,Empresa,Porcentaje,Estatus,idvendedor,Usuario,Contra){
  
  document.getElementById('idvendedor').value=idvendedor;
  document.getElementById('Nombre').value=Nombre;
  document.getElementById('Apellidos').value=Apellidos;
  document.getElementById('Telefono').value=Telefono;
  document.getElementById('Telefono').readOnly=true;
  document.getElementById('Empresa').value=Empresa;
  document.getElementById('Porcentaje').value=Porcentaje;
  document.getElementById('user-checkbox1').checked=Estatus;
  document.getElementById('usuario').value=Usuario;
  document.getElementById('usuario').readOnly=true;
  document.getElementById('contra').value=Contra;
  document.getElementById('contra2').value=Contra;
  if(Estatus=="ACTIVADO")
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


