<?php 
use App\Helpers\Session;
 ?>

<head>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<main>
    <section>
        <div class="heading">
            <h3>Profile Details</h3>
            <a class="edit" href="<?= $dashboard ?>"><- Back to Dashboard</a>
        </div>

        <div class="profile-details">
            <div>
                <h4>Employee-id</h4>
                <p><?= Session::get('user_id') ?></p>
            </div>
            <div>
                <h4>Name</h4>
                <p><?= Session::get('name') ?></p>
            </div>
            <div>
                <h4>Email</h4>
                <p><?= $profiledetails['email']?></p>
            </div>
            <div>
                <h4>Position</h4>
                <p><?= $profiledetails['position'] ?></p>
            </div>
            <div>
                <h4>Role</h4>
                <p><?= $roles[$profiledetails['role']] ?></p>
            </div>
            <div>
                <h4>Date of Joining</h4>
                <p><?= $profiledetails['date_of_joining'] ?></p>
            </div>
            <div>
                <h4>Created At</h4>
                <p><?= $profiledetails['created_at'] ?></p>
            </div>
            <div>
                <h4>Status</h4>
                <h6 class="<?= $statusClass ?>"><?= $statusText ?></h6>
            </div>
        </div>

        <div class="contact-head">
            <h3>Contact Details</h3>
        </div>

        <div class="profile-details">
            <div>
                <h4>Email</h4>
                <p><?= htmlspecialchars($profiledetails['email']) ?></p>
            </div>
            <div>
                <h4>Mobile Number</h4>
                <p><?= htmlspecialchars($profiledetails['phone']) ?></p>
            </div>
            <div>
                <h4>Address</h4>
                <p><?= htmlspecialchars($profiledetails['address']) ?></p>
            </div>
        </div>
    </section>
</main>
