 <ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar" >
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="border-top: 2px solid black; border-right: none; border-left: 2px solid black; border-bottom: 2px solid black; background: linear-gradient(to bottom right, #FFD400);">

         <div class="sidebar-brand-icon">
             <img src="img/logo/logo.png">
         </div>
         <div class="sidebar-brand-text mx-3">AMS</div>
     </a>
     <hr class="sidebar-divider my-0">
     <li class="nav-item active">
         <a class="nav-link" href="index.php">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>
     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Class and Sections
     </div>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
             <i class="fas fa-chalkboard"></i>
             <span>Manage Classes</span>
         </a>
         <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Classes</h6>
                 <a class="collapse-item" href="createClass.php">Create Class</a>
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapusers" aria-expanded="true" aria-controls="collapseBootstrapusers">
             <i class="fas fa-code-branch"></i>
             <span>Manage Sections</span>
         </a>
         <div id="collapseBootstrapusers" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Sections</h6>
                 <a class="collapse-item" href="createClassArms.php">Create Sections</a>
             </div>
         </div>
     </li>
     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Teachers
     </div>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapassests" aria-expanded="true" aria-controls="collapseBootstrapassests">
             <i class="fas fa-chalkboard-teacher"></i>
             <span>Manage Teachers</span>
         </a>
         <div id="collapseBootstrapassests" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Class Teachers</h6>
                 <a class="collapse-item" href="createClassTeacher.php">Create Class Teachers</a>
             </div>
         </div>
     </li>

     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Students
     </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2" aria-expanded="true" aria-controls="collapseBootstrap2">
             <i class="fas fa-user-graduate"></i>
             <span>Manage Students</span>
         </a>
         <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Students</h6>
                 <a class="collapse-item" href="createStudents.php">Create Students</a>
             </div>
         </div>
     </li>

     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Session & Term
     </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon" aria-expanded="true" aria-controls="collapseBootstrapcon">
             <i class="fa fa-calendar-alt"></i>
             <span>Manage Session & Term</span>
         </a>
         <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Contribution</h6>
                 <a class="collapse-item" href="createSessionTerm.php">Create Session and Term</a>
             </div>
         </div>
     </li>
     
     <hr class="sidebar-divider">

 </ul>