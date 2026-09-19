      <footer class="sl-footer">
        <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; 2018. Dale Más Bajo. Todos los derechos reservados.</div>
          <div>Sitio web desarrollado por <a href="http://shiftandcontrol.com">Shift & Ctrl</a></div>
        </div>
        
      </footer>
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script>window.DMB_ADMIN = { baseUrl: "<?= base_url(); ?>", userId: "<?= $this->session->userdata('id_usuario'); ?>" };</script>
    <script src="<?= base_url('assets/admin/vendor/jquery/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/popper.js/popper.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/bootstrap/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/jquery-ui/jquery-ui.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/jquery.sparkline.bower/jquery.sparkline.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/highlightjs/highlight.pack.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/d3/d3.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/rickshaw/rickshaw.min.css'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/chart.js/Chart.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/Flot/jquery.flot.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/Flot/jquery.flot.pie.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/Flot/jquery.flot.resize.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/flot-spline/jquery.flot.spline.js'); ?>"></script>
    
    <script src="<?= base_url('assets/admin/vendor/datatables/jquery.dataTables.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/datatables-responsive/dataTables.responsive.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/select2/js/select2.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/starlight.js?v=1.5'); ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/spectrum/spectrum.js'); ?>"></script>
    
    <script src="<?= base_url('assets/front/vendor/jplayer/jquery.jplayer.min.js'); ?>"></script>
    <script src="<?= base_url('assets/front/vendor/jplayer/jplayer.playlist.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/ResizeSensor.js'); ?>"></script>
    <? if(isset($aditional_scripts)){ ?>
        <? echo $aditional_scripts; ?>
    <? } ?>

    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $sc): ?>
            <?php if (preg_match('/^https?:\/\//i', $sc)): ?>
            <script src="<?= $sc; ?>"></script>
            <?php else: ?>
            <script src="<?= base_url($sc); ?>?v=<?= file_exists(FCPATH . $sc) ? filemtime(FCPATH . $sc) : '1.0'; ?>"></script>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

  </body>
</html>