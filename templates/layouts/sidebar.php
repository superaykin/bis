<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"><b><i class="fa fa-clone"></i> MODULES</b></li>
		    <li><a href="./" onclick="actvloader();"><i class="fa fa-tachometer  text-aqua"></i> <span>Dashboard</span></a></li>

        <li><a href="./entity.php?page=list" onclick="actvloader();"><i class="fa fa-user  text-aqua"></i> <span>Profiling</span></a></li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-home text-aqua"></i>
            <span>Center</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./center.php?page=list"><i class="fa fa-circle-o"></i> Development Center</a></li>
            <li><a href="./class.php?page=list"><i class="fa fa-circle-o"></i> Center Class</a></li>
          </ul>
        </li>

        <?php if(lookup_role('REP_ADMIN') === true) :  ?>
        <li class="header"><b><i class="fa fa-pie-chart"></i> REPORT</b></li>
        <li><a href="./eccd.php?page=report" onclick="actvloader();"><i class="fa fa-area-chart  text-aqua"></i> <span>ECCD Report</span></a></li>

        <?php endif; ?>


        <?php if(lookup_role('SYS_ADMIN') <> false OR lookup_role('CARDINAL') <> false) : ?>

        <li class="header"><b><i class="fa fa-user"></i> ADMINISTRATION</b></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog text-aqua"></i>
            <span>Settings</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="system.php?page=users"><i class="fa fa-circle-o"></i> System Users</a></li>
            <li><a href="system.php?page=locations"><i class="fa fa-circle-o"></i> Locations</a></li>
          </ul>
        </li>

        <?php endif; ?>

        <li class="header"><b><i class="fa fa-cog"></i> SYSTEM</b></li>
		    <li><a href="./sysinfo.php?page=about" onclick="actvloader();"><i class="fa fa-info  text-aqua"></i> <span>About</span></a></li>

      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>
