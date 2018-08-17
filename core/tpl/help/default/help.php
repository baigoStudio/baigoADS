<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="<?php echo substr($this->config['lang'], 0, 2); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $this->lang['mod']['page']['help']; ?></title>

    <!--jQuery 库-->
    <script src="<?php echo BG_URL_STATIC; ?>lib/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>

    <!--bootstrap-->
    <link href="<?php echo BG_URL_STATIC; ?>lib/bootstrap/4.1.3/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BG_URL_STATIC; ?>lib/iconic/1.1.0/css/open-iconic-bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BG_URL_STATIC; ?>lib/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BG_URL_STATIC; ?>help/<?php echo BG_DEFAULT_UI; ?>/css/help.css" type="text/css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-expand-md navbar-dark bg-dark mb-3">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bg-collapse" aria-controls="bg-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="bg-collapse">
                <div class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="./">
                        <img alt="baigo ADS" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
                    </a>
                </div>
                <ul class="navbar-nav">
                    <?php foreach ($this->help['nav'] as $key_nav=>$value_nav) {
                        if (isset($value_nav['sub'])) { ?>
                            <li class="nav-item dropdown<?php if ($this->help['mod'][$this->tplData['mod']]['active'] == $key_nav) { ?> active<?php } ?>">
                                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    <?php if (isset($this->lang['mod']['page'][$key_nav])) {
                                        echo $this->lang['mod']['page'][$key_nav];
                                    } else {
                                        echo $value_nav['title'];
                                    } ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php foreach ($value_nav['sub'] as $key_sub=>$value_sub) { ?>
                                        <a class="dropdown-item<?php if ($this->tplData['mod'] == $key_sub) { ?> active<?php } ?>" href="<?php echo BG_URL_HELP; ?>index.php?m=<?php echo $key_sub; ?>">
                                            <?php if (isset($this->lang['mod']['page'][$key_sub])) {
                                                echo $this->lang['mod']['page'][$key_sub];
                                            } else {
                                                echo $value_sub;
                                            } ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item<?php if ($this->help['mod'][$this->tplData['mod']]['active'] == $key_nav) { ?> active<?php } ?>">
                                <a href="<?php echo BG_URL_HELP; ?>index.php?m=<?php echo $key_nav; ?>" class="nav-link">
                                    <?php if (isset($this->lang['mod']['page'][$key_nav])) {
                                        echo $this->lang['mod']['page'][$key_nav];
                                    } else {
                                        echo $value_nav['title'];
                                    } ?>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </nav>
        </div>
    </header>


    <div class="container">
        <h2>
            <?php echo $this->lang['mod']['page']['help']; ?>
        </h2>
        <hr>
        <div class="row">
            <div class="col-md-10">
                <a name="top"></a>
                <?php echo $this->tplData['content'];

                if ($this->tplData['mod'] == 'tpl' && $this->tplData['act'] == 'rcode') { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap"><?php echo $this->lang['common']['page']['rcode']; ?></th>
                                    <th><?php echo $this->lang['mod']['label']['desc']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->lang['rcode'] as $key_rcode=>$value_rcode) { ?>
                                    <tr>
                                        <td><?php echo $key_rcode; ?></td>
                                        <td><?php echo $value_rcode; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <div>&nbsp;</div>
                <div class="text-right">
                    <a href="#top">
                        <span class="oi oi-chevron-top"></span>
                        top
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked flex-column bg-nav-ads">
                    <?php if (isset($this->help['mod'][$this->tplData['mod']]['menu'])) {
                        foreach ($this->help['mod'][$this->tplData['mod']]['menu'] as $key_menu=>$value_menu) { ?>
                            <li class="nav-item">
                                <a href="<?php echo BG_URL_HELP; ?>index.php?m=<?php echo $this->tplData['mod']; ?>&a=<?php echo $key_menu; ?>" class="nav-link<?php if ($this->tplData['act'] == $key_menu) { ?> active<?php } ?>">
                                    <?php if (isset($this->lang['mod'][$this->tplData['mod']][$key_menu])) {
                                        echo $this->lang['mod'][$this->tplData['mod']][$key_menu];
                                    } else {
                                        echo $value_menu;
                                    } ?>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
    </div>

    <footer class="container">
        <hr>
        <ul class="list-inline">
            <?php if (BG_DEFAULT_UI == 'default') { ?>
                <li class="list-inline-item"><a href="http://www.baigo.net/" target="_blank">baigo Studio</a></li>
                <li class="list-inline-item"><a href="http://www.baigo.net/cms/" target="_blank">baigo CMS</a></li>
                <li class="list-inline-item"><a href="http://www.baigo.net/sso/" target="_blank">baigo SSO</a></li>
                <li class="list-inline-item"><a href="http://www.baigo.net/ads/" target="_blank">baigo ADS</a></li>
            <?php } else { ?>
                <li class="list-inline-item"><?php echo BG_DEFAULT_UI; ?> ADS</li>
            <?php } ?>
        </ul>

        <div class="mt-3 text-right">
            <?php echo PRD_ADS_POWERED, ' ';
            if (BG_DEFAULT_UI == 'default') { ?>
                <a href="<?php echo PRD_ADS_URL; ?>" target="_blank"><?php echo PRD_ADS_NAME; ?></a>
            <?php } else {
                echo BG_DEFAULT_UI, ' ADS ';
            }
            echo PRD_ADS_VER; ?>
        </div>
    </footer>

    <!--bootstrap-->
    <script src="<?php echo BG_URL_STATIC; ?>lib/popper/1.12.9/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/4.1.3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/prism/prism.min.js" type="text/javascript"></script>

    <!--
        <?php echo PRD_ADS_POWERED, ' ';
        if (BG_DEFAULT_UI == 'default') {
            echo PRD_ADS_NAME;
        } else {
            echo BG_DEFAULT_UI, ' ADS ';
        }
        echo PRD_ADS_VER; ?>
    -->

</body>
</html>
