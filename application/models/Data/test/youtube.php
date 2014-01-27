<?php
    return array(
        'fields' => array(
            'youtube_id'    => array('label' => 'ID Y', 'noList' => true),
            'user'          => array('noList' => true),
            'title'         => array()
        ),
        'settings' => array(
            'singular'              => 'vidéo Youtube',
            'plural'                => 'vidéos Youtube',
            'orderList'             => 'title',
            'checkTuple'            => 'youtube_id',
            'orderListDirection'    => 'ASC'
        )
    );
