<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- User image -->

        <?php
        if ($_SESSION['avatar'] == "") { ?>
            <img src="images/user/user-default.png" class="user-image" alt="User Image" />
        <?php
        } else { ?>
            <img src="images/user/<?php echo $_SESSION['avatar']; ?>" class="user-image" alt="User Image" />
        <?php
        }
        ?>

        <span class="hidden-xs"><?php echo $_SESSION['nama_user']; ?> <i style="margin-left:5px" class="fa fa-angle-down"></i></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-primary">

            <?php
            if ($_SESSION['avatar'] == "") { ?>
                <img src="images/user/user-default.png" class="img-circle" alt="User Image" />
            <?php
            } else { ?>
                <img src="images/user/<?php echo $_SESSION['avatar']; ?>" class="img-circle" alt="User Image" />
            <?php
            }
            ?>

            <p>
                <?php echo $_SESSION['nama_user']; ?>
                <small><?php echo $_SESSION['bidang']; ?></small>
            </p>
        </li>

        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a style="width:80px" href="?module=profil" class="btn btn-default btn-flat float-left">Profil</a>
            </div>

            <div class="pull-right">
                <a style="width:80px" id="logout_button"  class="btn btn-default btn-flat float-right">Logout</a>
            </div>
        </li>
    </ul>
</li>