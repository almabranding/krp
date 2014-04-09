<table>
    <?php
    foreach ($this->menus as $menu) {
        $this->list = $menu;
        $this->getView('table');
    }
    ?>
</table>