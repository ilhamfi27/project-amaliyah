<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo base_url(); ?>assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Alexander Pierce</p>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form (Optional) -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
						</button>
					</span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">Menu</li>
			<!-- Optionally, you can add icons to the links -->
			<li class="active"><a href="<?php echo site_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<li><a href="<?php echo site_url('member/index'); ?>"><i class="fa fa-link"></i> <span>Member</span></a></li>
			<li><a href="<?php echo site_url('aktifitas/index'); ?>"><i class="fa fa-link"></i> <span>Amaliyah</span></a></li>
			<li><a href="<?php echo site_url('hadist/index'); ?>"><i class="fa fa-link"></i> <span>Hadist</span></a></li>
			<li><a href="<?php echo site_url('prodi/index'); ?>"><i class="fa fa-link"></i> <span>Prodi</span></a></li>
		</ul>
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>