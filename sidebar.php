<!-- Sidebar -->
<?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pengurus'): ?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-star"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sejati</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-home"></i>
            <span>Dashboard</span></a>
    </li>
    <?php if ($_SESSION['role'] == 'admin'): ?>
    <li class="nav-item">
        <a class="nav-link" href="penguruspending.php">
            <i class="fas fa-folder"></i>
            <span>Validasi Pengurus Sekolah</span></a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseValidasi" aria-expanded="true" aria-controls="collapseValidasi">
        <i class="fas fa-folder"></i>
        <span>Validasi Siswa</span>
    </a>
    <div id="collapseValidasi" class="collapse" aria-labelledby="headingValidasi" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="siswapending.php">Pending</a>
            <a class="collapse-item" href="siswatolak.php">Rejected</a>
        </div>
    </div>
</li>
    <?php if ($_SESSION['role'] == 'admin'): ?>
    <li class="nav-item">
        <a class="nav-link" href="datasekolah.php">
            <i class="fas fa-folder"></i>
            <span>Data Sekolah</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="datapengurus.php">
            <i class="fas fa-folder"></i>
            <span>Data Pengurus</span></a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link" href="datasiswa.php">
            <i class="fas fa-folder"></i>
            <span>Data Siswa</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">Main</div>
<!-- Nav Items -->
<!-- Nav Item - Kesehatan -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKesehatan" aria-expanded="true" aria-controls="collapseKesehatan">
        <i class="fas fa-heartbeat"></i>
        <span>Kesehatan</span>
    </a>
    <div id="collapseKesehatan" class="collapse" aria-labelledby="headingKesehatan" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="kesehatan.php">Kuisioner</a>
            <a class="collapse-item" href="datakesehatanlaki.php">Data Kuisioner (L)</a>
            <a class="collapse-item" href="datakesehatanperempuan.php">Data Kuisioner (P)</a>
        </div>
    </div>
</li>

<!-- Nav Item - Perubahan -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePerubahan" aria-expanded="true" aria-controls="collapsePerubahan">
        <i class="fas fa-exchange-alt"></i>
        <span>Perubahan</span>
    </a>
    <div id="collapsePerubahan" class="collapse" aria-labelledby="headingPerubahan" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="perubahan.php">Kuisioner</a>
            <a class="collapse-item" href="dataperubahanlaki.php">Data Kuisioner (L)</a>
            <a class="collapse-item" href="dataperubahanperempuan.php">Data Kuisioner (P)</a>
        </div>
    </div>
</li>

<!-- Nav Item - Diet dan Olahraga -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOlahraga" aria-expanded="true" aria-controls="collapseOlahraga">
        <i class="fas fa-dumbbell"></i>
        <span>Diet dan Olahraga</span>
    </a>
    <div id="collapseOlahraga" class="collapse" aria-labelledby="headingOlahraga" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="olahraga.php">Kuisioner</a>
            <a class="collapse-item" href="dataperiksalaki.php">Data IMT dan BMR (L)</a>
            <a class="collapse-item" href="dataperiksaperempuan.php">Data IMT dan BMR (P)</a>
            <a class="collapse-item" href="datamager.php">Data Kuisioner Mager</a>
            <a class="collapse-item" href="datamakan.php">Data Kuisioner Makanan</a>
        </div>
    </div>
</li>

<!-- Nav Item - Kesehatan Mental -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMental" aria-expanded="true" aria-controls="collapseMental">
        <i class="fas fa-brain"></i>
        <span>Kesehatan Mental</span>
    </a>
    <div id="collapseMental" class="collapse" aria-labelledby="headingMental" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="mental.php">Kuisioner</a>
            <a class="collapse-item" href="datamental.php">Data Kuisioner Mental</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pernikahan -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenikah" aria-expanded="true" aria-controls="collapseMenikah">
        <i class="fas fa-ring"></i>
        <span>Pernikahan</span>
    </a>
    <div id="collapseMenikah" class="collapse" aria-labelledby="headingMenikah" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="menikah.php">Kuisioner</a>
            <a class="collapse-item" href="datamenikah.php">Data Kuisioner Menikah</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="kenakalan.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-exclamation-triangle"></i>
        <span>Kenakalan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="referensi.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-book"></i>
        <span>Referensi</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="tanyajawab.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-question-circle"></i>
        <span>QnA</span>
    </a>
</li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<?php endif; ?>
<!-- End of Sidebar -->

<?php if ($_SESSION['role'] == 'siswa'): ?>
<!-- Sidebar For Student-->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-star"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sejati</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-home"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
        <div class="sidebar-heading">Main</div>
    <!-- Nav Items -->
     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
    <a class="nav-link collapsed" href="kesehatan.php" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-heartbeat"></i>
        <span>Kesehatan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="perubahan.php" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-exchange-alt"></i>
        <span>Perubahan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="olahraga.php" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-dumbbell"></i>
        <span>Diet dan Olah raga</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="mental.php" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-brain"></i>
        <span>Kesehatan Mental</span>
    </a>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="menikah.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-ring"></i>
        <span>Pernikahan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="kenakalan.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-exclamation-triangle"></i>
        <span>Kenakalan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="referensi.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-lightbulb"></i>
        <span>Referensi</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="tanyajawab.php" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-question-circle"></i>
        <span>QnA</span>
    </a>
</li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<?php endif; ?>
<!-- End of Sidebar -->