<!DOCTYPE html>
<html ng-app="fuel">
<head>
    <title><?php echo $message; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="/app.less" type="text/css" rel="stylesheet/less">
    <script src="/bower_components/less.js/dist/less-1.6.2.js" data-concat="false"></script>
    <script async src="/bower_components/jquery/jquery.js"></script>
    <script async src="/bower_components/bootstrap/dist/js/bootstrap.js"></script>
</head>
<?php
$class = $status === 'valid' ? 'success' : 'danger';
?>
<body class=" bg-<?php echo $class; ?>">
<div id="content" class="container">
    <div class="col-md-4 col-md-push-4">
        <h1 class=" text-center"><?php echo $message; ?> </h1>
        <?php if ( $status === 'valid' ): ?>
            <div class="row">
                <div class="col-md-10 col-md-push-1">
                    <h2><strong>Issued to</strong>: </h2>

                    <h3><?php echo $issued_to; ?></h3>

                    <h2><strong>Amount</strong>: </h2>

                    <h3><?php printf( "$%0.2f", $amount ); ?></h3>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
