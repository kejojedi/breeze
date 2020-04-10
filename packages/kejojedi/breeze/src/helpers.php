<?php

use Kejojedi\Breeze\Html;
use Kejojedi\Breeze\Model;

function route($route)
{
    // routes are read via regex
}

function title($title)
{
    global $breeze;
    $breeze->title = $title;
}

function param($key)
{
    global $breeze;
    return $breeze->params[$key];
}

function database($table)
{
    /** @var \Illuminate\Database\Eloquent\Builder $model */
    $model = new Model;
    $model->setTable($table);
    return $model;
}

function validate($rules)
{
    global $breeze;
    if (!empty($_POST)) return $breeze->validate($rules);
    return false;
}

function data($key)
{
    return htmlspecialchars_decode($_POST[$key]);
}

function redirect($redirect)
{
    ob_start();
    header('Location: ' . $redirect);
    die();
}

function view($content)
{
    global $breeze;
    $content = new Html(null, null, $content);
    return $breeze->view($content);
}

function component($name)
{
    return include __DIR__ . '../../../../../components/' . $name . '.php';
}

function navbarPrimary($content)
{
    return new Html('nav', 'nav', $content, [
        'class' => 'navbar navbar-expand-md navbar-dark bg-primary',
    ]);
}

function navbarBrand($href, $content)
{
    return new Html('a', 'a', $content, [
        'href' => $href,
        'class' => 'navbar-brand',
    ]);
}

function navbarToggler($content)
{
    return new Html('button', 'button', $content, [
        'type' => 'button',
        'data-toggle' => 'collapse',
        'data-target' => '#navbar',
        'class' => 'navbar-toggler',
    ]);
}

function navbarTogglerIcon()
{
    return new Html('span', 'span', null, ['class' => 'navbar-toggler-icon']);
}

function navbarCollapse($content)
{
    return new Html('div', 'div', $content, [
        'id' => 'navbar',
        'class' => 'collapse navbar-collapse',
    ]);
}

function navbarNav($content)
{
    return new Html('ul', 'ul', $content, ['class' => 'navbar-nav ml-auto']);
}

function navItem($content)
{
    return new Html('li', 'li', $content, ['class' => 'nav-item']);
}

function navLink($href, $content)
{
    return new Html('a', 'a', $content, [
        'href' => $href,
        'class' => 'nav-link',
    ]);
}

function div($content)
{
    return new Html('div', 'div', $content);
}

function container($content)
{
    return new Html('div', 'div', $content, ['class' => 'container']);
}

function heading($content)
{
    return new Html('h1', 'h1', $content);
}

function paragraph($content)
{
    return new Html('p', 'p', $content);
}

function icon($icon)
{
    return new Html('i', 'i', null, ['class' => 'fas fa-' . $icon]);
}

function form($content)
{
    return new Html('form', 'form', $content, ['method' => 'post']);
}

function formGroup($content)
{
    return new Html('div', 'div', $content, ['class' => 'form-group']);
}

function label($content)
{
    return new Html('label', 'label', $content);
}

function input($name, $value = null)
{
    global $breeze;
    return new Html('input', null, null, [
        'name' => $name,
        'value' => htmlspecialchars($_POST[$name] ?? $value),
        'class' => 'form-control ' . ($breeze->error($name) ? 'is-invalid' : null),
    ]);
}

function error($name)
{
    global $breeze;
    return new Html('div', 'div', $breeze->error($name), ['class' => 'invalid-feedback']);
}

function submit($content)
{
    return new Html('button', null, $content, ['type' => 'submit']);
}

function button($content)
{
    return new Html('button', null, $content, ['type' => 'button']);
}

function horizontalRule()
{
    return new Html('hr');
}

function linebreak()
{
    return new Html('br');
}

function loop($items, $content)
{
    $loop = '';

    preg_match_all('|{(.*?)}|', $content, $matches);

    foreach ($items as $key => $value) {
        $item_content = $content;

        if ($value instanceof Model) {
            $value = $value->toArray();
        }
        else if (is_object($value)) {
            $value = (array)$value;
        }

        foreach ($matches[0] as $match) {
            $tag = trim($match, '{}');
            $keys = explode('.', $tag);
            $item = [$keys[0] => $value];

            foreach ($keys as $key) {
                $item = &$item[$key];
            }

            $item_content = str_replace($match, $item, $item_content);
        }

        $loop .= new Html(null, null, $item_content);
    }

    return $loop;
}

function hyperlink($href, $content)
{
    return new Html('a', 'a', $content, ['href' => $href]);
}

function row($content)
{
    return new Html('div', 'div', $content, ['class' => 'row']);
}

function column($content)
{
    return new Html('div', 'div', $content, ['class' => 'col']);
}

function columnAuto($content, $width = null)
{
    return new Html('div', 'div', $content, ['class' => 'col-auto']);
}

function card($content)
{
    return new Html('div', 'div', $content, ['class' => 'card']);
}

function cardHeader($content)
{
    return new Html('div', 'div', $content, ['class' => 'card-header']);
}

function cardBody($content)
{
    return new Html('div', 'div', $content, ['class' => 'card-body']);
}

function cardFooter($content)
{
    return new Html('div', 'div', $content, ['class' => 'card-footer']);
}

function listGroup($content)
{
    return new Html('ul', 'ul', $content, ['class' => 'list-group']);
}

function listGroupItem($content)
{
    return new Html('li', 'li', $content, ['class' => 'list-group-item']);
}

function paginate($elements)
{
    global $breeze;
    return $breeze->paginate($elements);
}

function logMessage($message)
{
    global $breeze;
    $breeze->logMessage($message);
}