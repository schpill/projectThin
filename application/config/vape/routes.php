<?php
    $routes = array();
    $routes['collection'] = array();

    /* ADMIN */
    $adminLogin = new Route();
    $adminLogin->setPath('backadmin/login');
    $adminLogin->setModule('admin');
    $adminLogin->setController('static');
    $adminLogin->setAction('login');
    array_push($routes['collection'], $adminLogin);

    $adminLogout = new Route();
    $adminLogout->setPath('backadmin/logout');
    $adminLogout->setModule('admin');
    $adminLogout->setController('static');
    $adminLogout->setAction('logout');
    array_push($routes['collection'], $adminLogout);

    $adminNoRight = new Route();
    $adminNoRight->setPath('backadmin/noRight');
    $adminNoRight->setModule('admin');
    $adminNoRight->setController('static');
    $adminNoRight->setAction('no-right');
    array_push($routes['collection'], $adminNoRight);

    $adminDashboard = new Route();
    $adminDashboard->setPath('backadmin/dashboard');
    $adminDashboard->setModule('admin');
    $adminDashboard->setController('static');
    $adminDashboard->setAction('dashboard');
    array_push($routes['collection'], $adminDashboard);

    $adminList = new Route();
    $adminList->setPath('backadmin/list/(.*)');
    $adminList->setModule('admin');
    $adminList->setController('static');
    $adminList->setAction('list');
    $adminList->setParam1('type');
    array_push($routes['collection'], $adminList);

    $adminImport = new Route();
    $adminImport->setPath('backadmin/import-(.*)');
    $adminImport->setModule('admin');
    $adminImport->setController('static');
    $adminImport->setAction('import');
    $adminImport->setParam1('type');
    array_push($routes['collection'], $adminImport);

    $adminEmptyCache = new Route();
    $adminEmptyCache->setPath('backadmin/emptyCache-(.*)');
    $adminEmptyCache->setModule('admin');
    $adminEmptyCache->setController('static');
    $adminEmptyCache->setAction('empty-cache');
    $adminEmptyCache->setParam1('type');
    array_push($routes['collection'], $adminEmptyCache);

    $adminAddItem = new Route();
    $adminAddItem->setPath('backadmin/item_add/(.*)');
    $adminAddItem->setModule('admin');
    $adminAddItem->setController('static');
    $adminAddItem->setAction('item-add');
    $adminAddItem->setParam1('type');
    array_push($routes['collection'], $adminAddItem);

    $adminViewItem = new Route();
    $adminViewItem->setPath('backadmin/item_view/(.*)/(.*)/(.*)');
    $adminViewItem->setModule('admin');
    $adminViewItem->setController('static');
    $adminViewItem->setAction('item-view');
    $adminViewItem->setParam1('type');
    $adminViewItem->setParam2('id');
    $adminViewItem->setParam3('key');
    array_push($routes['collection'], $adminViewItem);

    $adminEditItem = new Route();
    $adminEditItem->setPath('backadmin/item_edit/(.*)/(.*)/(.*)');
    $adminEditItem->setModule('admin');
    $adminEditItem->setController('static');
    $adminEditItem->setAction('item-edit');
    $adminEditItem->setParam1('type');
    $adminEditItem->setParam2('id');
    $adminEditItem->setParam3('key');
    array_push($routes['collection'], $adminEditItem);

    $adminDuplicateItem = new Route();
    $adminDuplicateItem->setPath('backadmin/item_duplicate/(.*)/(.*)/(.*)');
    $adminDuplicateItem->setModule('admin');
    $adminDuplicateItem->setController('static');
    $adminDuplicateItem->setAction('item-duplicate');
    $adminDuplicateItem->setParam1('type');
    $adminDuplicateItem->setParam2('id');
    $adminDuplicateItem->setParam3('key');
    array_push($routes['collection'], $adminDuplicateItem);

    $adminDeleteItem = new Route();
    $adminDeleteItem->setPath('backadmin/item_delete/(.*)/(.*)/(.*)');
    $adminDeleteItem->setModule('admin');
    $adminDeleteItem->setController('static');
    $adminDeleteItem->setAction('item-delete');
    $adminDeleteItem->setParam1('type');
    $adminDeleteItem->setParam2('id');
    $adminDeleteItem->setParam3('key');
    array_push($routes['collection'], $adminDeleteItem);

    $adminItem = new Route();
    $adminItem->setPath('backadmin/item/(.*)');
    $adminItem->setModule('admin');
    $adminItem->setController('static');
    $adminItem->setAction('item');
    $adminItem->setParam1('type');
    array_push($routes['collection'], $adminItem);

    $adminAdd = new Route();
    $adminAdd->setPath('backadmin/add/(.*)');
    $adminAdd->setModule('admin');
    $adminAdd->setController('static');
    $adminAdd->setAction('add');
    $adminAdd->setParam1('type');
    array_push($routes['collection'], $adminAdd);

    $adminEdit = new Route();
    $adminEdit->setPath('backadmin/edit/(.*)/(.*)');
    $adminEdit->setModule('admin');
    $adminEdit->setController('static');
    $adminEdit->setAction('edit');
    $adminEdit->setParam1('type');
    $adminEdit->setParam2('id');
    array_push($routes['collection'], $adminEdit);

    $adminDelete = new Route();
    $adminDelete->setPath('backadmin/delete/(.*)/(.*)');
    $adminDelete->setModule('admin');
    $adminDelete->setController('static');
    $adminDelete->setAction('delete');
    $adminDelete->setParam1('type');
    $adminDelete->setParam2('id');
    array_push($routes['collection'], $adminDelete);

    $adminView = new Route();
    $adminView->setPath('backadmin/view/(.*)/(.*)');
    $adminView->setModule('admin');
    $adminView->setController('static');
    $adminView->setAction('view');
    $adminView->setParam1('type');
    $adminView->setParam2('id');
    array_push($routes['collection'], $adminView);

    $admin = new Route();
    $admin->setPath('backadmin');
    $admin->setModule('admin');
    $admin->setController('static');
    $admin->setAction('dashboard');
    array_push($routes['collection'], $admin);

    /* API */

    $api = new Route();
    $api->setPath('api/(.*)/(.*)/(.*)');
    $api->setModule('www');
    $api->setController('api');
    $api->setAction('route');
    $api->setParam1('resource');
    $api->setParam2('key');
    $api->setParam3('uri');
    array_push($routes['collection'], $api);

    return $routes;
