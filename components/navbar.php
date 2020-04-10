<?php

return navbarPrimary(
    container(
        navbarBrand('/', icon('wind')->marginRight(2) . app_title) .
        navbarToggler(navbarTogglerIcon()) .
        navbarCollapse(
            navbarNav(
                navItem(navLink('/', 'Index')) .
                navItem(navLink('/cars', 'Cars'))
            )
        )
    )
);