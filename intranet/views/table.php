<form id="mainform" action="">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class='<?php echo ($this->list['sort']) ? 'sortable' : '' ?>'>      
        <?php
        if ($this->list['values']==null)
            return 0;
        echo ' <tr>';
        foreach ($this->list['title'] as $k => $value) {
            $style = 'width:' . $value['width'];
            $colspan = 'colspan="' . $value['colspan'] . '"';
            $nolink = (!$value['link'] || $value['link'] == '#') ? ' class="noOrder "' : '';
            echo '<th class="table-header-repeat line-left minwidth-1" style="text-transform:capitalize;' . $style . '" ' . $colspan . '><a' . $nolink . ' href="' . $value['link'] . '">' . $value['title'] . '</a></th>';
        }
        echo '</tr>';
        if ($this->list['values']==null)
            exit;
        foreach ($this->list['values'] as $k => $row) {
            if(!$this->list['noRow'])$alternate = (($k % 2) == 0) ? 'alternate-row' : '';
            $classRow=$this->list['classRow'][$k];
            echo '<tr class="'.$alternate.' '.$classRow.'">';
            foreach ($row as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
</form>