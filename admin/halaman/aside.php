    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo $ufoto?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $uname; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <?php 
          foreach ($db->find('tb_modul','status','1') as $key => $value) { ?>
            <li class="active treeview">
            <a href="index.php?pages=<?php echo $value['defaultlink'] ?>">
              <i class="fa fa-<?php echo $value['icon'] ?>"></i> <span><?php echo $value['namamodul'] ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
          </li>
          <?php }
           ?>      
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>