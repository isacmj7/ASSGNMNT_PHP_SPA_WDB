<?php
    error_reporting(0);
    require_once('config.php');

    if (isset($_GET["id"])) {
        $id = (int) $_GET["id"];
        $getfile = file_get_contents(DATA_FILE);
        $jsonfile = json_decode($getfile, true);
        $jsonfile = $jsonfile["users"];
        $jsonfile = $jsonfile["id_".$id];
    }

    include('template/header.php');
?>
<?php if (isset($_GET["id"])): ?>
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-xl-9">
        <h1 class="text-white mb-4">Add User</h1>
        <div class="card" style="border-radius: 15px;">
            <div class="card-body">
                <div class="row align-items-center pt-4 pb-3">
                    <div class="col-md-3 ps-5">
                        <h6 class="mb-0">ID</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                        <p><?php echo $jsonfile["id"] ?></p>
                    </div>
                </div>

                <hr class="mx-n3">

                <div class="row align-items-center pt-4 pb-3">
                    <div class="col-md-3 ps-5">
                        <h6 class="mb-0">Name</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                        <p><?php echo $jsonfile["name"] ?></p>
                    </div>
                </div>

                <hr class="mx-n3">

                <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">
                        <h6 class="mb-0">Image</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                        <img class="img" src="<?php echo IMG_ROOT . $jsonfile["image"]; ?>"></img>
                    </div>
                </div>

                <hr class="mx-n3">

                <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">
                        <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                        <p><?php echo $jsonfile["address"] ?></p>
                    </div>
                </div>

                <hr class="mx-n3">

                <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">
                        <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                        <p><?php echo $jsonfile["gender"] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php
    include('template/footer.php');
?>