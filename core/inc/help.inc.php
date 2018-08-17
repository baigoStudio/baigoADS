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
                'plugin'    => 'Plug-in Documentation',
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
                'attach'    => 'Image Management',
                'posi'      => 'Position',
                'admin'     => 'Administrator',
                'link'      => 'Link',
                'plugin'    => 'Plug-in Management',
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
                'common'    => 'Common Resources',
                'error'     => 'Alert Message',
                'rcode'     => 'Return Code',
            ),
        ),
        'plugin' => array(
            'active'    => 'doc',
            'menu'      => array(
                'outline'       => 'Plug-in Outline',
                'create'        => 'Create Plug-in',
                'programming'   => 'Programming',
                'obj_plugin'    => 'Plug-in Object',
                'data'          => 'Saving Plug-in Data',
                'class_file'    => 'Filesystem CLASS',
                'obj_db'        => 'Database Object',
                'hook'          => 'Plug-in Hooks',
                'action'        => 'Action Hooks',
                'filter'        => 'Filter Hooks',
            ),
        ),
    ),
);
