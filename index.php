<?php
    include('common.php');
    include('template/header.php');
?>
<a rel="button" class="btn btn-success float-end add-btn" href="<?php echo BASE_URL; ?>/add.php">Add User</a>
<table id="user-table" class="table table-fixed no-border clearfix">
    <thead>
        <tr class="clearfix">
            <th class="icon col-md-1" data-sorting="true" data-column="id" data-sort="asc">ID</th>
            <th class="icon col-md-2" data-sorting="true" data-column="name" data-sort="asc">Name</th>
            <th class="col-md-2">Image</th>
            <th class="col-md-3">Address</th>
            <th class="col-md-1">Gender</th>
            <th class="col-md-3">Action</th>
        </tr>
    </thead>
    <tbody id="user-tbody">
        <?php 
            if(!empty($json_data) && array_key_exists('users',$json_data)) {
                foreach ($json_data->users as $index => $obj):
        ?>
                <tr class="clearfix">
                    <td class="col-md-1"><?php echo $obj->id; ?></td>
                    <td class="col-md-2"><?php echo $obj->name; ?></td>
                    <td class="col-md-2">
                        <img class="img" src="<?php echo IMG_ROOT . $obj->image; ?>"></img>
                        <img class="icon" src="<?php echo IMG_ROOT; ?>arrow-down-circle-fill.svg" onclick="downloadUserImage('<?php echo $obj->id; ?>', '<?php echo BASE_URL; ?>/download.php?id=<?php echo $obj->id; ?>');"></img>
                    </td>
                    <td class="col-md-3"><?php echo $obj->address; ?></td>
                    <td class="col-md-1"><?php echo $obj->gender; ?></td>
                    <td class="col-md-3">
                        <a rel="button" class="btn btn-secondary" href="<?php echo BASE_URL; ?>/edit.php?id=<?php echo $obj->id; ?>">Edit</a>
                        <a rel="button" class="btn btn-danger" href="<?php echo BASE_URL; ?>/delete.php?id=<?php echo $obj->id; ?>">Delete</a>
                        <a rel="button" class="btn btn-primary" href="<?php echo BASE_URL; ?>/view.php?id=<?php echo $obj->id; ?>">View</a>
                    </td>
                </tr>
        <?php 
                endforeach; 
            } else {
        ?>
            <tr class="clearfix"><td colspan="6" class="col-md-12">No data found</td></tr>
        <?php } ?>
    </tbody>
</table>
<?php
    include('template/footer.php');
?>