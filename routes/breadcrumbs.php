<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('acara', function (BreadcrumbTrail $trail) {
    $trail->push('Acara', route('pembuat.dashboard'));
});
