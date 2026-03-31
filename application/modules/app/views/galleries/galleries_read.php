<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Posts Read</h2>
        <table class="table">
	    <tr><td>Guuid</td><td><?php echo $guuid; ?></td></tr>
	    <tr><td>Title</td><td><?php echo $title; ?></td></tr>
	    <tr><td>Slug</td><td><?php echo $slug; ?></td></tr>
	    <tr><td>Content</td><td><?php echo $content; ?></td></tr>
	    <tr><td>Category</td><td><?php echo $category; ?></td></tr>
	    <tr><td>Postimage</td><td><?php echo $postimage; ?></td></tr>
	    <tr><td>Postimagethumb</td><td><?php echo $postimagethumb; ?></td></tr>
	    <tr><td>Type</td><td><?php echo $type; ?></td></tr>
	    <tr><td>Metapost</td><td><?php echo $metapost; ?></td></tr>
	    <tr><td>Keywords</td><td><?php echo $keywords; ?></td></tr>
	    <tr><td>Commentstatus</td><td><?php echo $commentstatus; ?></td></tr>
	    <tr><td>Poststatus</td><td><?php echo $poststatus; ?></td></tr>
	    <tr><td>Createdat</td><td><?php echo $createdat; ?></td></tr>
	    <tr><td>Createdby</td><td><?php echo $createdby; ?></td></tr>
	    <tr><td>Updatedat</td><td><?php echo $updatedat; ?></td></tr>
	    <tr><td>Updatedby</td><td><?php echo $updatedby; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('posts') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>