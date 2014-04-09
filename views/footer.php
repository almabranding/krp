<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?= URL; ?>public/js/modernizr.js"></script>
<script src="<?= URL; ?>public/js/custom.js"></script>
<script src="<?= URL; ?>public/js/mobile.js"></script>
<script src="<?= URL; ?>public/js/zebra_form.js"></script>
<script src="<?= URL; ?>public/js/html2canvas.js"></script>

<?php
if (isset($this->js))
    foreach ($this->js as $js)
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
?>
</body>
</html> 