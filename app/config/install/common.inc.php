<?php return array(
    'index' => array(
        'index'     => 'PHP Extensions',
        'type'      => 'Installation type',
        'dbconfig'  => 'Database settings',
        'data'      => 'Create data',
        'admin'     => 'Add administrator',
        'over'      => 'Complete installation',
    ),
    'upgrade' => array(
        'index'     => 'PHP Extensions',
        'data'      => 'Update data',
        'admin'     => 'Add administrator',
        'over'      => 'Complete upgrade',
    ),
    'data' => array(
        'index' => array(
            'table' => array(
                'title' => 'Create table',
                'lists' => array(
                    'Admin',
                    'Advert',
                    'Attach',
                    'Link',
                    'Posi',
                    'Stat_Advert',
                    'Stat_Posi',
                ),
            ),
        ),
        'upgrade' => array(
            'table' => array(
                'title' => 'Create table',
                'lists' => array(
                    'Link',
                    'Stat_Advert',
                    'Stat_Posi',
                ),
            ),
            'rename' => array(
                'title' => 'Rename table',
                'lists' => array(
                    'Attach',
                ),
            ),
            'alter' => array(
                'title' => 'Update table',
                'lists' => array(
                    'Admin',
                    'Advert',
                    'Attach',
                    'Posi',
                ),
            ),
        ),
    ),
);
