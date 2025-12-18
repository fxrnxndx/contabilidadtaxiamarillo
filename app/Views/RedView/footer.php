<!-- Bootstrap core JavaScript-->
<script src=<?php echo (base_url("assets/js/jquery.min.js")); ?>></script>
<script src=<?php echo (base_url("assets/js/popper.min.js")); ?>></script>
<script src=<?php echo (base_url("assets/js/bootstrap.min.js")); ?>></script>

<!-- simplebar js -->
<script src=<?php echo (base_url("assets/plugins/simplebar/js/simplebar.js")); ?>></script>
<!-- sidebar-menu js -->
<script src=<?php echo (base_url("assets/js/sidebar-menu.js")); ?>></script>
<!-- loader scripts -->
<script src=<?php echo (base_url("assets/js/jquery.loading-indicator.js")); ?>></script>
<!-- Custom scripts -->
<script src=<?php echo (base_url("assets/js/app-script.js")); ?>></script>
<!-- Chart js -->

<script src=<?php echo (base_url("assets/plugins/Chart.js/Chart.min.js")); ?>></script>

<!-- Index js -->
<script src=<?php echo (base_url("assets/js/index.js")); ?>></script>

<script src=<?php echo (base_url("assets/js/axios.min.js")); ?>></script>

<script src=<?php echo (base_url("assets/js/administrador.js")); ?>></script>

<script src=<?php echo (base_url("assets/js/datatables.js")); ?>></script>

<!-- The Modal -->
<div class="modal fade" id="notificaciones">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title text-dark">NOTIFICACION</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <H3 class="text-dark"><span id="notificacion"></span></H3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php
$session = session();
$alerta = $session->getFlashdata('alerta');
if ($alerta): ?>
  <script>
    $('#notificacion').text('<?php echo $alerta ?>');
    $('#notificaciones').modal('show');
  </script>
<?php endif ?>
</body>

</html>