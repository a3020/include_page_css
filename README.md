# Include Page CSS

Version required: concrete5 5.7.5.

This add-on will look for a CSS file in the themes folder that corresponds with the currently viewed page.

## Purpose
You probably don't want very specific page styles to be loaded on every page load throughout your entire website. This provides a way to load specific page styles without having to use inline styles.

## How does it load

The **path to the source directory** can be specified in the config file located at /application/config/generated_overrides/include_page_css.php.

If a page specific CSS file exists, it will add a link tag, for example:

``
<link href="/application/themes/bootstrap/css/pages/855.css" rel="stylesheet" type="text/css" media="all">
``


## Comments
If you have an idea or suggestion, please submit an issue or a PR. 