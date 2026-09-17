<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Gyakorlat 3</title>
    <style>
        div{
            padding: 2%;
            margin: 20px;
            background-color: solid rgb(41, 41, 41);
        }
        body{
            background-color: rgb(44, 43, 43);
        }
        img{
            margin: 20px;
            border-radius: 5%;
        }
        pre{
            color: white;
        }
        span{
            color: white;
        }
    </style>
</head>
<body>
    <div class="container col-lg-6">
        <div>
        <img src="./system.png" alt="rendszer">
        </div>
        <div>
            <pre>1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
        link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
        inet 127.0.0.1/8 scope host lo
        valid_lft forever preferred_lft forever
        inet6 ::1/128 scope host noprefixroute
        valid_lft forever preferred_lft forever
    2: enp0s3: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UP group default qlen 1000
        link/ether 08:00:27:c0:68:56 brd ff:ff:ff:ff:ff:ff
        altname enx080027c06856
        inet 172.16.20.11/16 brd 172.16.255.255 scope global enp0s3
        valid_lft forever preferred_lft forever
        inet6 fe80::a00:27ff:fec0:6856/64 scope link proto kernel_ll
        valid_lft forever preferred_lft forever</pre>
        </div>
        <div>
        <pre>tomi     sshd pts/0   2026-09-17 09:57 (172.16.0.158)
                tomi     seat0        2026-09-17 09:51
                tomi     tty1         2026-09-17 09:51
    </pre>
    <div>
    <span>Az Ön kliensének IP címe:
        <span><?php
        echo $_SERVER["REMOTE_ADDR"];
        ?></span>
    </span>
    </div>
    </div>
</body>
</html>