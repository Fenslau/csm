<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Главная', route('home'));
});

Breadcrumbs::register('users', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Управление пользователями', route('users'));
});

Breadcrumbs::register('profile', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push($user->name, route('user', $user->id));
});

Breadcrumbs::register('role', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push($role->role_name, route('role', $role->id));
});

Breadcrumbs::register('otkaz', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Регистрация отказов', route('otkaz'));
});

Breadcrumbs::register('journals', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Журналы', route('journals'));
});
Breadcrumbs::register('journal-holod', function ($breadcrumbs) {
    $breadcrumbs->parent('journals');
    $breadcrumbs->push('Холодильники', route('journal-holod'));
});
Breadcrumbs::register('journal-holod-list', function ($breadcrumbs) {
    $breadcrumbs->parent('journal-holod');
    $breadcrumbs->push('Список холодильников', route('journal-holod-list'));
});
Breadcrumbs::register('journal-lampa', function ($breadcrumbs) {
    $breadcrumbs->parent('journals');
    $breadcrumbs->push('Бактерицидные лампы', route('journal-lampa'));
});
Breadcrumbs::register('journal-lampa-narabotka', function ($breadcrumbs) {
    $breadcrumbs->parent('journal-lampa');
    $breadcrumbs->push('Наработка ламп', route('narabotka-lamp'));
});
Breadcrumbs::register('journal-lampa-list', function ($breadcrumbs) {
    $breadcrumbs->parent('journal-lampa');
    $breadcrumbs->push('Список ламп', route('journal-lampa-list'));
});

Breadcrumbs::register('document', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Электронный документооборот', route('document'));
});
Breadcrumbs::register('procedure', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Процедурный кабинет', route('procedure'));
});

Breadcrumbs::register('otkaz-stat', function ($breadcrumbs) {
    $breadcrumbs->parent('otkaz');
    $breadcrumbs->push('Статистика отказов', route('otkaz-stat'));
});

Breadcrumbs::register('reason', function ($breadcrumbs) {
    $breadcrumbs->parent('otkaz');
    $breadcrumbs->push('Причины отказов', route('edit_otkaz_reasons'));
});
Breadcrumbs::register('theme', function ($breadcrumbs) {
    $breadcrumbs->parent('otkaz');
    $breadcrumbs->push('Темы отказов', route('edit_otkaz_themes'));
});

Breadcrumbs::register('cost', function ($breadcrumbs) {
    $breadcrumbs->parent('otkaz');
    $breadcrumbs->push('Стоимость отказов', route('edit_otkaz_costs'));
});
