<!doctype html>
<html>
    <head>
        <title>Maintenance Mode</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>
        html, body {
            height: 100%;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 200;
            font-family: 'Lato', sans-serif;
        }
        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }
        .content {
            text-align: center;
            display: inline-block;
        }
        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }
        </style>
      <meta http-equiv="refresh" content="4; url=https://billing.crazyrdp.com" />

    </head>
    <body>
        <div class="container">
            <div class="content">
                <!-- <div class="title">Be right back.</div> -->
                <h2 style="color:black">
                    my.crazyrdp.com is under maintenance!
                </h2>
                <h2 style="color:black">
                    {{ env('paragraph_content') }}<br>
                  You can still use our "old" billing panel to purchase/manage servers.<br><br>
                  You will be automatically redirected in 5 seconds.<br><br>
                  If not, click here: <a href="https://billing.crazyrdp.com">billing.crazyrdp.com</a>
                </p>
            </div>
        </div>
    </body>
</html>