<?php
return array(
    'base' => array(
        'title' => 'Base settings',
        'lists' => array(
            'site_name' => array(
                'title'      => 'Site name',
                'type'       => 'str',
                'format'     => 'text',
                'require'    => 'true',
            ),
            'site_perpage' => array(
                'title'      => 'Count of per page',
                'type'       => 'str',
                'format'     => 'text',
                'require'    => 'true',
            ),
            'site_date' => array(
                'title'     => 'Date format',
                'type'      => 'select_input',
                'note'      => 'Select or fill in the format parameter of the <code>date</code> function',
                'require'   => 'true',
                'option'    => array(
                    'Y-m-d'     => date('Y-m-d'),
                    'y-m-d'     => date('y-m-d'),
                    'M. d, Y'   => date('M. d, Y'),
                ),
            ),
            'site_date_short' => array(
                'title'     => 'Short date format',
                'type'      => 'select_input',
                'require'   => 'true',
                'note'      => 'Select or fill in the format parameter of the <code>date</code> function',
                'option'    => array(
                    'm-d'   => date('m-d'),
                    'M. d'  => date('M. d'),
                ),
            ),
            'site_time' => array(
                'title'     => 'Time format',
                'type'      => 'select_input',
                'require'   => 'true',
                'note'      => 'Select or fill in the format parameter of the <code>date</code> function',
                'option'    => array(
                    'H:i:s'     => date('H:i:s'),
                    'h:i:s A'   => date('h:i:s A'),
                ),
            ),
            'site_time_short' => array(
                'title'     => 'Short time format',
                'type'      => 'select_input',
                'require'   => 'true',
                'note'      => 'Select or fill in the format parameter of the <code>date</code> function',
                'option'    => array(
                    'H:i'   => date('H:i'),
                    'h:i A' => date('h:i A'),
                ),
            ),
        ),
    ),
    'upload' => array(
        'title' => 'Upload settings',
    ),
    'sso' => array(
        'title' => 'SSO Settings',
        'lists' => array(
            'base_url' => array(
                'title'     => 'Base url',
                'type'      => 'str',
                'format'    => 'url',
                'require'   => 'true',
            ),
            'app_id' => array(
                'title'     => 'APP ID',
                'type'      => 'str',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'app_key' => array(
                'title'     => 'APP KEY',
                'type'      => 'str',
                'format'    => 'text',
                'require'   => 'true',
            ),
            'app_secret' => array(
                'title'     => 'APP SECRET',
                'type'      => 'str',
                'format'    => 'text',
                'require'   => 'true',
            ),
        ),
    ),
    'dbconfig' => array(
        'title' => 'Database settings',
    ),
    'chkver' => array(
        'title' => 'Check for updates',
    ),
);