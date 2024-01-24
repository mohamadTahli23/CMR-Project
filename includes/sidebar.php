<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
    <?php

    $aid = $_SESSION['name'];
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/', $link);
    $page = end($link_array);


    $id = $_SESSION['sturecmsaid'];
    $sql = "SELECT admin FROM user WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $isAdmin = $stmt->fetch(PDO::FETCH_COLUMN);
    if ($isAdmin == 1)  {
        // Admin user
        $isAdmin = true;
    } else {
        // Regular user
        $isAdmin = false;
    }
    ?>
    <li class="nav-item" style="border-bottom: 1px solid #efefef;">
        <p class="nav-link mb-0"><?= __('welcome') ?><span class="px-1" style="color: #7436B4;"><?php echo $aid ?> !</span></p>

    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My Reminders">
        <a class="nav-link <?php if ($page == 'dashboard.php') { ?> active <?php } ?>" href="dashboard.php">
            <i class="fa-solid fa-bell"></i>
            <span class="nav-link-text"><?= __('My Reminders') ?></span>
        </a>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Add Reminder">
        <a class="nav-link <?php if ($page == 'add-reminder.php') { ?> active <?php } ?>" href="add-reminder.php">
            <i class="fa-solid fa-bell"></i>
            <span class="nav-link-text"><?= __('Add Reminder') ?></span>
        </a>
    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="History Reminder">
        <a class="nav-link <?php if ($page == 'history_reminder.php') { ?> active <?php } ?>" href="history_reminder.php">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span class="nav-link-text"><?= __('Reminders History') ?></span>
        </a>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My Cars">
        <a class="nav-link <?php if ($page == 'my-cars.php') { ?> active <?php } ?>" href="my-cars.php">
            <i class="fa-solid fa-car-side"></i>
            <span class="nav-link-text"><?= __('My Cars') ?></span>
        </a>
    </li>

    <?php   if ($isAdmin)  { ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Add city">
            <a class="nav-link <?php if ($page == 'city.php') { ?> active <?php } ?>" href="city.php">
                <i class="fa-solid fa-city"></i>
                <span class="nav-link-text"><?= __('Cities') ?></span>
            </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Near Services">
            <a class="nav-link <?php if ($page == 'add-services.php') { ?> active <?php } ?>" href="add-services.php">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <span class="nav-link-text"><?= __('Add Services') ?></span>
            </a>
        </li>

    <?php } ?>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Near Services">
        <a class="nav-link <?php if ($page == 'near-services.php') { ?> active <?php } ?>" href="near-services.php">
            <i class="fa-solid fa-location-dot"></i>
            <span class="nav-link-text"><?= __('Service Providers') ?></span>
        </a>
    </li>
    <?php   if ($isAdmin)  { ?>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin Panel">
        <a class="nav-link <?php if ($page == 'admin_panel.php') { ?> active <?php } ?>" href="admin_panel.php">
            <i class="fa-solid fa-building-user"></i>
            <span class="nav-link-text"><?= __('Admin Panel') ?></span>
        </a>
    </li>
    <?php } ?>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profile">
        <a class="nav-link <?php if ($page == 'profile.php') { ?> active <?php } ?>" href="profile.php">
            <i class="fa-solid fa-user"></i>
            <span class="nav-link-text"><?= __('Profile') ?></span>
        </a>
    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Change Password">
        <a class="nav-link <?php if ($page == 'change-password.php') { ?> active <?php } ?>" href="change-password.php">
            <i class="fa-solid fa-lock"></i>
            <span class="nav-link-text"><?= __('Change Password') ?></span>
        </a>
    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Logout">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa-solid fa-power-off"></i><?= __('Logout') ?></a>
    </li>

</ul>
<ul class="topNav navbar-nav align-items-center justify-content-between w-100">
    <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center mr-lg-2">
            <div class="person">
                <i class="fa-solid fa-user"></i>
            </div>

            <span> <?php echo $aid ?></span>
        </a>
    </li>

    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a class="nav-link  mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-globe"></i>
                <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning"></span>
              </span>
                <span class="indicator text-warning d-none d-lg-block">

              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                <a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=en">
                    <strong>English</strong>

                </a>
                <a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=ar">
                    <strong>عربي</strong>

                </a>

            </div>
        </li>
    </ul>

</ul>