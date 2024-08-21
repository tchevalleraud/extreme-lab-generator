<?php
    global $config;
    include_once "Config.php";
    include_once "param.php";
    include_once "vendor/autoload.php";

    use phpseclib3\Net\SFTP;

    for($pod = 1; $pod <= 1; $pod++){
        for($i = 1; $i <= 1; $i++){
            $name = "RTR-CORE".$pod."-0$i";
            $directory = "/var/www/export/pod".$pod."/".$name."/";

            $node = new \App\Config($directory);

            $node->addLine("config terminal");
            $node->addLine("boot config flags advanced-feature-bandwidth-reservation vim");
            $node->addLine("boot config flags sshd");
            $node->addLine("ssh");
            $node->addLine("mgmt oob");
            $node->addLine("ip address ".$config[$name]['ip']."/24");
            $node->addLine("ip route 0.0.0.0/0 next-hop ".$config['mgmtgw']."");
            $node->addLine("enable");
            $node->addLine("exit");
            $node->export("config_init.cfg");

            $node->addLine("interface GigabitEthernet 1/1-1/2");
            $node->addLine("encapsulation dot1q");
            $node->addLine("no shutdown");
            $node->addLine("exit");
            $node->export("config_lab1.cfg");

            $node->upload($config[$name]['ip'], "rwa", "rwa", "/intflash/");
        }
    }