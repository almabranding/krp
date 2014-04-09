<div id="header">
    <input id="menuCheck" type="checkbox">
<label for="menuCheck" onclick=""></label>
    <div id="logo">
        <div class="wrapper">
            <a href="<?=URL?>"><img src="/public/img/logo.png"></a></div>
    </div><div id="menuNav">
        <div class="wrapper">
            <ul>
                <li><a class="blue <?=(stripos(PATH,'work'))?'selected':''?>" href='<?= URL ?>work'><?= $this->lang['Work'] ?></a>
                <li><a class="blue2 <?=(stripos(PATH,'info'))?'selected':''?>" href='<?= URL ?>info'><?= $this->lang['Info'] ?></a>
                <li><a class="pink <?=(stripos(PATH,'archive'))?'selected':''?>" href='<?= URL ?>archive'><?= $this->lang['Archive'] ?></a>
                <li><a class="pink2 <?=(stripos(PATH,'krp'))?'selected':''?>" href='<?= URL ?>krp'><?= $this->lang['K/R + P'] ?></a>
            </ul>
        </div>
    </div>
</div>



