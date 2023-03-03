<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Exceptions\DuplicateBreadcrumbException;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.

// User
try {
    Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
        $trail->push('User', route('management-user.index'));
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}
//// User > edit
try {
    Breadcrumbs::for('user-edit', function (BreadcrumbTrail $trail) {
        $trail->parent('user');
        $trail->push('User Edit');
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}
//// User > show
try {
    Breadcrumbs::for('user-show', function (BreadcrumbTrail $trail) {
        $trail->parent('user');
        $trail->push('User Detail');
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}


try {
    Breadcrumbs::for('patrolconfig', function (BreadcrumbTrail $trail) {
        $trail->push('Konfigurasi Patroli', route('patrolconfig.index'));
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}


try {
    Breadcrumbs::for('patrolconfig.create', function (BreadcrumbTrail $trail) {
        $trail->parent('patrolconfig')
            ->push('Tambah Konfigurasi Patroli', route('patrolconfig.create'));
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}


try {
    Breadcrumbs::for('master.company', function (BreadcrumbTrail $trail) {
        $trail->push('Master Company', route('master.company.index'));
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}

try {
    Breadcrumbs::for('company', function (BreadcrumbTrail $trail) {
        $trail->parent('master.company')
            ->push('Master Company', route('master.company.show'));
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}

try {
    Breadcrumbs::for('master.company.show', function (BreadcrumbTrail $trail) {
        $trail->parent('master.company')
            ->push('Master Company Detail');
    });
} catch (DuplicateBreadcrumbException $e) {
    Log::error($e->getMessage());
}
