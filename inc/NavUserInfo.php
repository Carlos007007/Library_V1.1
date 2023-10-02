<nav class="navbar-user-top full-reset">
    <ul class="list-unstyled full-reset">
        <figure>
            <?php
                if($_SESSION['UserPrivilege']=='Student'){
                    $imgUser='user03';
                }else if($_SESSION['UserPrivilege']=='Teacher'){
                    $imgUser='user02';
                }else if($_SESSION['UserPrivilege']=='Admin'){
                    $imgUser='user01';
                }else if($_SESSION['UserPrivilege']=='Personal'){
                    $imgUser='user05';
                }else{
                    $imgUser='user';
                }
                echo '<img src="'.$LinksRoute.'assets/img/'.$imgUser.'.png" alt="user-picture" class="img-responsive img-circle center-box">';
            ?> 
        </figure>
        <li style="color:#fff; cursor:default;">
            <span class="all-tittles"><?php echo $_SESSION['UserName']; ?></span>
        </li>
        <li  class="tooltips-general exit-system-button" data-href="<?php echo $LinksRoute; ?>process/logout.php" data-placement="bottom" title="Salir del sistema">
            <i class="zmdi zmdi-power"></i>
        </li>
        <li  class="tooltips-general search-book-button" data-href="<?php echo $LinksRoute; ?>searchbook.php" data-placement="bottom" title="Buscar libro">
            <i class="zmdi zmdi-search"></i>
        </li>
        <li  class="tooltips-general btn-help" data-placement="bottom" title="Ayuda">
            <i class="zmdi zmdi-help-outline zmdi-hc-fw"></i>
        </li>
        <li class="mobile-menu-button visible-xs" style="float: left !important;">
            <i class="zmdi zmdi-menu"></i>
        </li>
    </ul>
</nav>