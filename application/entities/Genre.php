<?php
    namespace ThinEntity;

    class Genre
    {
        public $fields = array(
            'name'    => array('label' => 'Nom')
        );

        public $settings = array(
            'relationships' => array(
                'produits' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
            ),
            'orderList' => 'name',
            'orderListDirection'    => 'ASC'
        );
    }
