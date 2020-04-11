<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\MessageBag;
use Kejojedi\Breeze\Auth;
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

function parameter($key)
{
    global $breeze;
    return $breeze->parameters[$key];
}

function database($table)
{
    $model = new Model;
    $model->setTable($table);

    /** @var Builder $model */
    return $model;
}

function validate($rules)
{
    global $breeze;
    if (!empty($_POST)) return $breeze->validate($rules);
    return false;
}

function decode($key)
{
    return trim(htmlspecialchars_decode($_POST[$key]));
}

function decodes($keys)
{
    $keys = func_get_args();
    $formData = [];
    foreach ($keys as $key) $formData[$key] = decode($key);
    return $formData;
}

function old($name, $default = null)
{
    $old = $_POST[$name] ?? $default;
    return htmlspecialchars($old);
}

function passwordHash($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function authLogin($user)
{
    (new Auth)->login($user);
}

function authLogout()
{
    (new Auth)->logout();
}

function authCheck()
{
    return (new Auth)->check();
}

function authGuest()
{
    return !(new Auth)->check();
}

function authUser()
{
    return (new Auth)->user();
}

function authAttempt($credentialKey, $passwordKey)
{
    global $breeze;
    $user = (new Auth)->attempt(decode($credentialKey), decode($passwordKey));
    if (!$user) $breeze->errors = (new MessageBag)->add($credentialKey, 'Invalid credentials entered.');
    return $user;
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

function navbarLight($content)
{
    return new Html('nav', 'nav', $content, [
        'class' => 'navbar navbar-expand-md navbar-light bg-light',
    ]);
}

function navbarDark($content)
{
    return new Html('nav', 'nav', $content, [
        'class' => 'navbar navbar-expand-md navbar-dark bg-dark',
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

function span($content)
{
    return new Html('span', 'span', $content);
}

function container($content)
{
    return new Html('div', 'div', $content, ['class' => 'container']);
}

function headingOne($content)
{
    return new Html('h1', 'h1', $content);
}

function headingTwo($content)
{
    return new Html('h2', 'h2', $content);
}

function headingThree($content)
{
    return new Html('h3', 'h3', $content);
}

function headingFour($content)
{
    return new Html('h4', 'h4', $content);
}

function headingFive($content)
{
    return new Html('h5', 'h5', $content);
}

function headingSix($content)
{
    return new Html('h6', 'h6', $content);
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
        'value' => $value,
        'class' => 'form-control ' . ($breeze->error($name) ? 'is-invalid' : null),
    ]);
}

function checkbox($name, $label, $value = false)
{
    global $breeze;
    $checked = $value ? ['checked' => 'checked'] : [];
    return new Html('div', 'div',
        new Html('input', null, null, array_merge(['type' => 'checkbox', 'name' => $name, 'id' => $name, 'class' => 'custom-control-input'], $checked)) .
        new Html('label', 'label', $label, ['for' => $name, 'class' => 'custom-control-label'])
        , ['class' => 'custom-control custom-checkbox']
    );
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

function formRow($content)
{
    return new Html('div', 'div', $content, ['class' => 'form-row']);
}

function column($content)
{
    return new Html('div', 'div', $content, ['class' => 'col']);
}

function columnOne($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-1']);
}

function columnTwo($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-2']);
}

function columnThree($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-3']);
}

function columnFour($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-4']);
}

function columnFive($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-5']);
}

function columnSix($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-6']);
}

function columnSeven($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-7']);
}

function columnEight($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-8']);
}

function columnNine($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-9']);
}

function columnTen($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-10']);
}

function columnEleven($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-11']);
}

function columnTwelve($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-12']);
}

function columnAuto($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-auto']);
}

function columnDesktop($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md']);
}

function columnDesktopOne($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-1']);
}

function columnDesktopTwo($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-2']);
}

function columnDesktopThree($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-3']);
}

function columnDesktopFour($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-4']);
}

function columnDesktopFive($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-5']);
}

function columnDesktopSix($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-6']);
}

function columnDesktopSeven($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-7']);
}

function columnDesktopEight($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-8']);
}

function columnDesktopNine($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-9']);
}

function columnDesktopTen($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-10']);
}

function columnDesktopEleven($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-11']);
}

function columnDesktopTwelve($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-12']);
}

function columnDesktopAuto($content)
{
    return new Html('div', 'div', $content, ['class' => 'col-md-auto']);
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