<!DOCTYPE html>
<?php include 'route.php'; ?>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <?php include 'layout/head.php'; ?>
    </head>
    <!-- END: Head -->
    <body class="main">
        <?php include 'layout/menu.php'; ?>
        <!-- BEGIN: Content -->
        <div class="wrapper wrapper--top-nav">
            <?php include 'content/'.$page . ".php"; ?>
        </div>
        <!-- END: Content -->
        
        
        <!-- BEGIN: JS Assets-->
        <script src="dist/js/app.js"></script>
        <script src="plugin/datatable/jquery-3.5.1.js"></script>
        <script src="plugin/datatable/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
        <!-- END: JS Assets-->
        <script type="text/javascript">
            document.getElementById("menucustom").style.width = '15.5rem';
        </script>
    </body>
</html>