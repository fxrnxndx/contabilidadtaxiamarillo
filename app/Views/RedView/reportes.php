
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
       CHOFER AGREGADO CORRECTAMENTE
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary bg-dark " data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
<!-- Modal FIN-->
<form action="<?php  echo(base_url("Home/BuscarReporte"));?>" method="post" accept-charset="utf-8">
<!--INICIO AGREGAR -->
<div class="card col-4">
      <div class="card-content">
          <div class="row row-group m-0">
          <div class="form-group ">
            <label for="input-1">Seleccione busqueda</label>
            <select class="form-control" aria-label="Default select example" id="busqueda" name="busqueda" required>
              <option selected>buscar por:  </option>
              <option value="1">Empresa</option>
              <option value="2">Chofer</option>
              <option value="3">Vendedor</option>
              
            </select>
           </div>
          </div>
          
         
      </div>
   </div>  
<!--FIN AGREGAR -->



<!--INICIO BUSCADOR -->
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
         
          <div class="form-group " id="choferes">
            
           </div>
          <div class="form-group">
            <label for="input-1">Fecha inicial</label>
            <input type="date" class="form-control" id="FechaInicial" name="fechainicial" placeholder="Ingresar nombre">
            <label for="input-1">Hora y minuto inicial</label>
            <input type="time" class="form-control"id="HoraInicial" name="HoraInicial" value="00:00:00" required>
           </div>
          <div class="form-group">
            <label for="input-1">Fecha final</label>
            <input type="date" class="form-control" id="FechaFinal" name="fechafinal" placeholder="Ingresar nombre">
            <label for="input-1">Hora y minuto final</label>
            <input type="time" class="form-control"id="HoraFinal" name="HoraFinal" value="00:00:00" required>
           </div>
           <div class="form-group">
            <label for="input-1">Descargar reporte</label>
            <button type="submit" class="btn btn-light px-10 form-control" ><i class="zmdi zmdi-flickr"></i> Descargar</button>
           </div>
      </div>
   </div>  
</form>
<!--FIN BUSCADOR -->






<!--INICIO TABLA -->


<div class="row" >
       <div class="col-12 col-lg-12">
         <div class="card">
           <div class="card-header"><h4>REPORTES</h4>
           <img src=<?php  echo(base_url("assets/images/reporte.jpg"));?> class="rounded" alt="Eniun" width="100%">
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
			toastr.warning("FAVOR DE SELECCIONAR UNA EMPRESA Y TIPO DE BUSQUEDA");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
     if(document.getElementById("notificacion").value=="2")
		 {
			toastr.error("NO SE ENCONTRO INFORMACION");
      <?php $this->session->set('NOTIFICACION','0'); ?>
		 }
  paginacion();
});
//Traer la informacion de los choferes cuando busca por chofer
$("#busqueda").change(function() {
   
  $("#busqueda option:selected").each(function() {
    valor = $(this).val();
    if(valor==2){
      $("#Empresa").change(function() {

      $("#Empresa option:selected").each(function() {
        valor = $(this).val();
        if(valor!=0){
          $.get("https://contabilidad.taxis-aeropuerto-tj.com/Home/BuscarChofer", { valor }, function(data) {
          $("#choferes").html(data);
          });
        }
      else
      {
       $("#choferes").html("");
      }
  
});

});      
    }
    else
    {
      $("#choferes").html("");
    }
  
  
});
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


