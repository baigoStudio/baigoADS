<?php
return array(
    'nav' => array(
        'intro' => array(
            'title' => 'Introduction',
        ),
        'install' => array(
            'title' => 'Setup / Upgrade',
            'sub'   => array(
                'setup'     => 'Setup',
                'upgrade'   => 'Upgrade',
                'manual'    => 'Manual Setup / Upgrade',
                'deploy'    => 'Advanced deployment',
            ),
        ),
        'console' => array(
            'title' => 'The Console',
        ),
        'doc' => array(
            'title' => 'Documentation',
            'sub'   => array(
                'script'    => 'Ad Script',
                'tpl'       => 'Template Documentation',
            ),
        ),
    ),

    'mod' => array(
        'intro' => array(
            'active'    => 'intro',
            'menu'      => array(
                'outline'   => 'Introduction',
                'faq'       => 'FAQ',
            ),
        ),
        'setup' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Setup Outline',
                'phplib'       => 'Extension Check',
                'dbconfig'  => 'Database Settings',
                'dbtable'   => 'Create Database',
                'base'      => 'Base Settings',
                'upload'    => 'Uploading Settings',
                'sso'       => 'SSO Settings',
                'admin'     => 'Create Administrator',
                'over'      => 'Complete Setup',
            ),
        ),
        'upgrade' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Upgrade Outline',
                'phplib'       => 'Extension Check',
                'dbconfig'  => 'Database Settings',
                'dbtable'   => 'Upgrade Database',
                'base'      => 'Base Settings',
                'upload'    => 'Uploading Settings',
                'sso'       => 'SSO Settings',
                'admin'     => 'Create Administrator',
                'over'      => 'Complete Upgrade',
            ),
        ),
        'manual' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Manual Outline',
                'dbconfig'  => 'Database Settings',
                'base'      => 'Base Settings',
                'upload'    => 'Uploading Settings',
                'sso'       => 'SSO Settings',
            ),
        ),
        'deploy' => array(
            'active'    => 'install',
            'menu'      => array(
                'outline'   => 'Advanced Deployment',
            ),
        ),
        'console' => array(
            'active'    => 'console',
            'menu'      => array(
                'outline'   => 'The Console Outline',
                'advert'    => 'Advertisement',
                'media'     => 'Image Management',
                'posi'      => 'Position',
                'admin'     => 'Administrator',
                'link'      => 'Link',
                'opt'       => 'Settings',
            ),
        ),
        'script' => array(
            'active'    => 'doc',
            'menu'      => array(
                'outline'   => 'Script Outline',
                'cfg'       => 'Config',
                'data'      => 'Ad Data',
                'advert'    => 'Ad Script',
                'use'       => 'Use',
            ),
        ),
        'tpl' => array(
            'active'    => 'doc',
            'menu'      => array(
                'outline'   => 'Template Outline',
                'error'     => 'Alert Message',
                'rcode'     => 'Return Code',
            ),
        ),
    ),
);
