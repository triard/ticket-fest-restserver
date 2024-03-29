
    <!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>
<body id="page-top">

<?php $this->load->view("admin/_partials/navbar.php") ?>

<div id="wrapper">

	<?php $this->load->view("admin/_partials/sidebar.php") ?>

	<div id="content-wrapper">
<br><br><br>
        <!-- /.container-fluid -->
        <div class="container" style="margin-left: 225px;">
    <div class="row">
        <div class="col">
        <?php $this->load->view("admin/_partials/breadcrumb.php") ?>
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo site_url(); ?>CategoryClient/put_process" class="needs-validation" method="POST" onload="setSelectBoxByText()">
                        <?php foreach ($menu as $rows) : ?>
                            <div class="form-group">
                                <input type="text" class="form-control" id="id_category" placeholder="ID Menu" value="<?php echo $rows->id_category; ?>" name="id_category" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Nama" value="<?php echo $rows->name; ?>" name="name" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="descripsi" id="descripsi" cols="30" rows="5" >
                                <?php echo $rows->desc; ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            <script>
                                function setSelectBoxByText(eid, etxt) {
                                    var eid = document.getElementById(eid);
                                    for (var i = 0; i < eid.options.length; ++i) {
                                        if (eid.options[i].text === etxt)
                                            eid.options[i].selected = true;
                                    }
                                }
                                var eid = "kategori";
                                var etxt = document.getElementById("selected").value;
                                document.getElementById("selected").style.display = "none";
                                setSelectBoxByText(eid, etxt)
                            </script>
                        <?php endforeach; ?>
                    </form>
                    <a href="<?php echo site_url(); ?>CategoryClient/" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>  back</a>
                </div>
            </div>
        </div>
    </div>		<!-- Sticky Footer -->


	</div>
	<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->


<?php $this->load->view("admin/_partials/scrolltop.php") ?>
<?php $this->load->view("admin/_partials/modal.php") ?>
<?php $this->load->view("admin/_partials/js.php") ?>
    
</body>
</html>