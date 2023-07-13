# newtralize

**newtralize is a clean and minimal Joomla 4 template designed to neutralize Joomla and stay out of your way.**

No opinionated CSS to fight with, easy marketing implementation, just a pleasant experience.

- [Basic Layout](#basic-layout)
- [Utility Classes](#utility-classes)
- [Configuration Options](#configuration-options)
- [Adding CSS](#adding-css)
- [Adding Javascript](#adding-javascript)
- [Adding GA Conversion Tags](#adding-ga-conversion-tags)

## Basic Layout

newtralize is set up with basic module positions, sufficient to create almost any design.

<img src="https://res.cloudinary.com/da9s7ps5c/image/upload/v1677767034/newtralize_layout_3f4d3d0490.jpg" height="512" />

## Utility Classes

newtralize comes equipped with a few handy utility classes to help you build your layouts.

- `.show-desktop-only`: Will hide an element on small screens
- `.show-mobile-only`: Will hide an element on large screens
- `.container-width`: Will confine an element to the max container width (set by `--container-width`)
- `.visually-hidden`: Will hide an element visually, but keep it visible to screen readers
- `.flow`: Provides an easy vertical spacing container. Can customize the space with `--flow-space`

## Configuration Options

### Joomla Settings

**Header Logo:** Define a logo for the site

**Title:** Define an alternate site title

### CSS Settings

**Remove Joomla CSS:** Remove the CSS file Joomla normally adds to the head

### JavaScript Settings

**Remove Joomla JavaScript:** Remove the JavaScript files Joomla normally adds to the head

**Use Instant.page:** Use Instant.page to speed up your site. More info at [instant.page](https://instant.page)

### Tracking Settings

**Google Tag Manager Container ID:** Add Google Tag Manager ID to add GTM code to the site

**Google Analytics ID:** Add Google Analytics ID to add GA code to the site

**Facebook Pixel ID:** Add Facebook Pixel ID to add Pixel code to the site

### Icons

**Custom FontAwesome URL:** Define a FontAwesome kit URL

### Layout/Module Settings

Enable or disable module positions

**Copyright Notice:** Add a custom copyright notice. If left blank, the site name will be used.

### Custom Code Settings

Insert custom code in &lt;head&gt; and &lt;body&gt; tags

## Adding CSS

### Global Custom CSS

Create a CSS file in `/css/` named `custom.css`. This file will be included on every page.

### Menu-Specific CSS

You can also define CSS styles that will only be present within a given menu. Create a CSS file in `/css/menus/` named with the menu's alias. For example, if your menu's alias is `main-menu`, create `main-menu.css`.

### Menu Item-Specific CSS

You can also define CSS styles that will only be present on a specific menu item. Create a CSS file in `/css/pages/` named with the menu item's alias. For example, if your page's alias is `contact`, create `contact.css`.

## Adding JavaScript

### Global Custom JavaScript

Create a JS file in `/js/` named `custom.js`. This file will be included on every page.

### Menu-Specific JavaScript

You can also define JavaScript that will only be present within a given menu. Create a JS file in `/js/menus/` named with the menu's alias. For example, if your menu's alias is `main-menu`, create `main-menu.js`.

### Menu Item-Specific JavaScript

You can also define JavaScript that will only be present on a specific menu item. Create a JS file in `/js/pages/` named with the menu item's alias. For example, if your page's alias is `contact`, create `contact.js`.

## Adding GA Conversion Tags

To add Google Analytics conversion tag code to a specific page, create a PHP file in `/heads/gaconversions/` named with the menu item's alias. For example, if your tag should go on the page `contact`, create `contact.php`.
