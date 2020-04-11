<?php

return navbarPrimary(
    container(
        navbarBrand('/', icon('wind')->marginRight(2) . app_title) .
        navbarToggler(navbarTogglerIcon()) .
        navbarCollapse(
            navbarNav(
                authGuest() ?
                    navItem(navLink('/auth/login', 'Login')) .
                    navItem(navLink('/auth/register', 'Register'))
                    :
                    navItem(navLink('/cars', 'Cars')) .
                    navItem(navLink('/auth/logout', 'Logout'))
            )
        )
    )
);