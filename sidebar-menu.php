<a href="main.php?module=home" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
    <div class="os-resize-observer-host observed">
        <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
        <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 944px;"></div>
    <div class="os-padding">
        <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <nav class="mt-2">
                    <?php
                    $home = $_GET["module"]=="home"?"active":"";
                    $send = $_GET["module"]=="send"?"active":"";
                    $get = $_GET["module"]=="get"?"active":"";
                    $manage = $_GET["module"]=="manage"?"active":"";
                    if ($_SESSION["bidang"]!=null) { ?>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="main.php?module=home" class="nav-link <?php echo $home?>">
                                    <i class="nav-icon fa fa-home"></i>
                                    <p>
                                        Beranda
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="main.php?module=send" class="nav-link <?php echo $send?> ">
                                    <i class="nav-icon fa fa-file-alt"></i>
                                    <p>
                                        Kirim Ticket
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="main.php?module=get" class="nav-link <?php echo $get?>">
                                    <i class="nav-icon fa fa-file-alt"></i>
                                    <p>
                                        Terima Ticket
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="main.php?module=manage" class="nav-link <?php echo $manage?>">
                                    <i class="nav-icon fa fa-file-alt"></i>
                                    <p>
                                        Kelola Ticket
                                    </p>
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                </nav>

            </div>
        </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
        <div class="os-scrollbar-track">
            <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
        </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
        <div class="os-scrollbar-track">
            <div class="os-scrollbar-handle" style="height: 69.5364%; transform: translate(0px, 0px);"></div>
        </div>
    </div>
    <div class="os-scrollbar-corner"></div>
</div>