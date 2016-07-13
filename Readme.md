# Maketador #

WordPress theme based on [underscore.me](http://underscores.me/) and [Bootstrap 3](http://getbootstrap.com).

## What makes it different ? ##

- Works with JetPack Infinite Scroll
- Customizer options
  - Header :
    - Header types: Fixed, Static, Normal and Normal Fixed 
    - Logo upload
  - Layout :
    - Types: sidebar-content, content-sidebar
  - Footer : 
    - Footer text
  - Core : 
    - Header Image
    - Display Site Title and Tagline
    - Background Image
- Page templates : 
  - FullWidth
  - Inverse Layout  
  - Blank (no title)
  - Blank No Container
- Widget areas : 
  - Sidebar
  - Footer
- Extra image sizes
  - maketador_featured 880x430 px
  - maketador_banner 1200x500 px
- All options accessible on customizer and saved on theme_mod 
- Child Theme for replacing all files   
- Right to left support [bootstrap-rtl](http://github.com/morteza)

### Principles ###

- "Use WordPress filters instead less or js"
- "Use one theme for multiple Bootstrap header types"
- "Use customizer not theme options page"
- "Do not try to hide WordPress (use plugins for that)"
- "Only 2 widget areas (add more with code or plugins)"
- "Do not reinvent the wheel"
- "Lightweight"

## Files Description ##
- `inc/extras.php` 
  - Origin: underscore
  - Edits: none
- `inc/maketador_jetpack.php` 
  - Origin: underscore
  - Edits: infinite scroll footer content from theme_mod -> footer_text 
- `inc/maketador_bootstrap.php` 
  - Origin: Maketador
  - Notes: Adds active menu class to categories archive, modifies the caption shortcode, the password form, adds label
   class to the tag widget, enables shortcodes on text widgets, adds btn classes to the more link, adds thumbnail 
   classes to attachment links, adds comments custom fields and form.     
- `inc/template-tags.php` 
  - Origin: underscore
  - Edits: added underboot_edit_link
  - Notes: Has replaceable functions
    - underboot_posted_on
    - underboot_entry_footer
    - underboot_edit_link
- `inc/maketador_customizer.php` 
  - Origin: Maketador
  - Notes: Handles all customizer options header, layout, footer and core.  
- `inc/wp-bootstrap-navwalker.php` 
  - Origin: [wp-bootstrap-navwalker](https://github.com/twittem/wp-bootstrap-navwalker)
  - Edits: none   
- `inc/wp_bootstrap_pagination.php` 
  - Origin: [wp_bootstrap_pagination](https://github.com/sigami/wp_bootstrap_pagination)
  - Edits: text_domain   
- `functions.php` 
  - Origin: Maketador
  - Edits: made all includes replaceable by child theme 
  - Notes: enqueue scripts and includes all other files which are releasable with child themes.
    - underboot_setup 
- `page-templates`
  - Origin: UnderBoot
  - Notes: affects header.php in some cases.
- All other files
  - Origin: underscore
  - Edits: 
    - Minor modifications to css classes. 
    - Most changed files header.php, footer.php and 404.php
  

## Developer guide ##

To get the juice out of this code you will need to have [Node.js](https://nodejs.org/en/) installed on your system.

Also bower and grunt-cli installed globally.

Using grunt is just mind blowing. 

If you are not using it, you are missing out on some incredible powers.

### Created for Child Themes ###

Why create new themes all the time if child themes exists since year 0.

Create a child theme using grunt

`grunt child --slug=my_theme --name="My Theme"`

this will create a new child theme with grunt already installed.

use `grunt clean:dev` to remove the bower_components and node_modules folder.

### Builder settings ###

1. Go to builder path `cd maketador/`
2. Run `npm install`
3. Run `bower install`
4. Modify `inc/less/main.less` or `inc/less/botswatch.less` to your needs
5. Add extra scripts if necessary on `inc/js`
6. Run `grunt build`

Use `grunt watch` to watch changes on files and auto reload browser very useful if your are developing on a local server.

To automatically copy your changes to a test folder first create a **variables.json** file like this:

Then ese `grunt dev` this will also reload the browser.

``````json
{
    "test_dir" : "/full-path/to/localhost/wp-content/themes/maketador/"
}
``````

Use `grunt zip` to create a zip file with only the essential. Use that file to upload the theme via wp-admin.
  

## Contribute ##

Create a pull request to the master branch.

## Changelog ##

### 1.0.1 13/07/2016 ###
- Bug fixes, hard testing, sweat and blood.

### 1.0.0 08/06/2016 ###
- Birth