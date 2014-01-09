<?php
    namespace ThinService;
    class Data extends \Thin\Data
    {
        public static function getVendorsByCategory($category, $zoneSearch)
        {
            $res = parent::query('fournisseur', 'category = ' . $category . ' || category2 = ' . $category, 0, 0, 'place');
            $collection = array();
            $param  = \Thin\Session::instance('param');
            $info = $param->getInfo();
            if (count($res)) {
                foreach ($res as $item) {
                    $zones = array();
                    if (null !== $item->getZone()) {
                        array_push($zones, $item->getZone());
                    }
                    if (null !== $item->getZone2()) {
                        array_push($zones, $item->getZone2());
                    }
                    if (null !== $item->getZone3()) {
                        array_push($zones, $item->getZone3());
                    }
                    if (null !== $item->getZone4()) {
                        array_push($zones, $item->getZone4());
                    }
                    if (!count($zones)) {
                        $zones = array(1);
                    }
                    if (\Thin\Arrays::inArray($zoneSearch, $zones)) {
                        array_push($collection, $item);
                    }
                }
            }
            return $collection;
        }

        public static function getProductsByVendor($vendor)
        {
            $collection = array();
            $products = parent::query('produit', 'vendor = ' . $vendor, 0, 0, 'name');
            if (count($products)) {
                foreach ($products as $product) {
                    array_push($collection, $product);
                }
            }
            return $collection;
        }

        public static function getProductsByCategory($category)
        {
            $collection = array();
            //*GP* $vendors = parent::query('fournisseur', 'category = ' . $category, 0, 0, 'name');
            $vendors = parent::query('fournisseur', 'category = ' . $category . ' || category2 = ' . $category, 0, 0, 'name');
            if (count($vendors)) {
                foreach ($vendors as $vendor) {
                    $products = parent::query('produit', 'vendor = ' . $vendor->getId(), 0, 0, 'name');
                    if (count($products)) {
                        foreach ($products as $product) {
                            array_push($collection, $product);
                        }
                    }
                }
            }
            return $collection;
        }
    }
