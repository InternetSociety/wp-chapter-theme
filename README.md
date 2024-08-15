Internet Society WordPress Theme
================================

This theme is designed to be used by Internet Society (ISOC) chapters and other ISOC-related entities to create WordPress sites using the same general design.

More information - and the theme files themselves - can be found at:

> <https://github.com/InternetSociety/wp-chapter-theme>

**IMPORTANT**: If you'd encounter issues using this theme (or have suggestions for changes), please check the issue tracker and raise a new issue if necessary:

> <https://github.com/InternetSociety/wp-chapter-theme/issues>

The issue tracker is public and *viewing* the issues is open to all. *Raising* an issue requires a [Github](http://www.github.com) account, but those are available for free.

------------------------------------------------------------------------

Outline
------------------------------

This ReadMe document covers the following:
> 1. [Installation](#0§-installation)
> 2. [Customizing the theme ](#02-custom)
> 3. [Support / Questions](#03-support)
> 4. [Contributors and Contributing Changes](#04-contribute)

------------------------------------------------------------------------

------------------------------------------------------------------------

<a name="01-installation"></a>
## Installation ##
------------------------------

Download the ZIP file of this repository:
<https://github.com/InternetSociety/wp-chapter-theme/archive/refs/heads/main.zip>

Next, in your WordPress admin area, do the following:

1. Go to *"Appearance* -> *"Themes"*, choose "Add New" and then choose the "Upload Theme" button,
2. Upload the ZIP file you downloaded,
3. Activate the theme Internet Chapters

------------------------------------------------------------------------

<a name="02-custom"></a>
### Customize the Theme with a Site Title, Tagline and Chapter Logo

1. Go to *"Appearance"* -> *"Customize"* -> *"Site Identity"*
2. Set the "Site Title",
3. Set the "Tagline",
3. Set the "Chapter Logo",
5. Save the settings by clicking the "Save & Publish" button at the top.

### Manage your navigation menus.
1. In your site admin, under Appearance -> Menus,
2. manage your main navigation in the header and footer menu items as needed


### Adding Items to Left Sidebar on the Homepage

1. Go to *"Appearance"* -> *"Widgets"*
2. Find the "Sidebar Home" Area.
3. Drag and drop Text or other widget types and make appropriate changes.

### Adding Items to Left Sidebar on Other (Internal) Pages

1. Go to *"Appearance"* -> *"Widgets"*
2. Find the "Sidebar" Area.
3. Drag and drop Text or other widget types and make appropriate changes.

### Adding a "News" Section

If you would like to add a "News" section to your site that lists all your posts, you can follow these steps. Note that this is _not_ required and can also be done at any later time. As noted in the steps, it does not have to be called "News" but could use another name instead.

1. Create a new Page ( *"Pages"* -> *"Add New"* ) that will be used for displaying all your posts. It only has to have a name and URL as WordPress will supply the content:

![News Page Name](https://raw.github.com/InternetSociety/isoc-wp/master/images/readme-blogpagename.png)

It is common to use "News" here with a URL of "news", but you could use another name if you want to. Publish this page so that it is available.

By default the "News" Section is set as the Homepage. In order to change this, follow the steps below.
2. Go to *"Settings"* -> *"Reading"*
3. For "_Front page displays_" choose "A static page".
4. Change "_Posts page_" to be the name of the page you just created.
5. Change "_Front page_" to be the name of one of your other pages - or a specific blank page you create for this purpose.

![News Page Configuration](https://raw.github.com/InternetSociety/isoc-wp/master/images/readme-blogpage.png)

After you save the changes, all of your posts will be visible at "< yoursite >/news", assuming you used "News" as your page name.

------------------------------------------------------------------------

<a name="04-config"></a>
## Configuration ##
------------------------------

This section includes changes that you may want to make on an ongoing basis during the regular usage of your theme.

All of the steps assume you are logged into WordPress, have access to the administration panels of your site and have the required plugins installed.

### Changing the Chapter Logo

1.  From the left-hand column, go to *"Appearance"* -> *"Customize"* and click on "Site Identity"
2.  Browse to upload a new image at Chapter Logo,
3.  Press the "Save & Publish" button.

**NOTE**: The Chapter Logo should be at least 200 pixels wide and 50 pixels tall.

Official ISOC chapter logos can be found at: http://www.internetsociety.org/identity/en
If you are seeking a logo that is not listed please contact chapter-support@isoc.org

### Assigning the Default Header

1.  From the left-hand column, go to *"Appearance"* -> *"Customize"* and click on "ISOC Defaults"
2.  Browse to upload a new image at Default Header,
3.  Press the "Save & Publish" button.

**NOTE**: The Default Header should be at least 1600 pixels wide and 500 pixels tall.

The Default Header will be shown on the pages where no Featured Image (see below) is selected.

### Assigning the 404 Page

1.  From the left-hand column, go to *"Appearance"* -> *"Customize"* and click on "ISOC Defaults"
2.  Select a page to show as your 404 (not found) page,
3.  Press the "Save & Publish" button.

### Modifying Menus

1. From the left-hand column, go to *"Appearance"* -> *"Customize"* and click on "Menus"
2. Select the appropriate menu tab to edit the menu.
3. Click "Add Items". Select the page you wish to add to the menu.
4. Drag and drop a menu items to be in the correct order.
5. Press the "Save & Publish" button.

**NOTE**: The "Main Menu" can hold max 4 items.

### Adding a Featured Image to a Post

If you add a "Featured Image" to a post, a thumbnail of that image will then appear next to the text when the post is included in a list of posts, such as an archive or category.

1. Edit the post to which you want to add a Featured Image.
2. Near the bottom of the right sidebar find the "Featured Image" box and click the *"Set Featured Image"* link. If you do not see the "Featured Image" box, see the note below.
3. Choose the image you want to use, either by uploading a new image or choosing an existing image from the "Media Gallery".
4. Select the *"Set Featured Image"* button to set the image and close the window.
4. Click the *"Update"* button to update the post with the added featured image.

**NOTE**: If you do not see a "Featured Image" box in the right sidebar it is most likely because WordPress is not set to show that box. Go to the top right corner of the WordPress window and click on "Screen Options" near your name:

![Screen Options](https://raw.github.com/InternetSociety/isoc-wp/master/images/readme-screenoptions.png)

In the panel that opens up, check the box next to "Featured Image" to display that box
in the sidebar. When you are done you can click "Screen Options" again to hide this panel.

------------------------------------------------------------------------

> ### Example: Creating Additional Categories and Widgets ###
> ------------------------------
>
> You are free to create whatever widgets and categories you wish, but if you would like an example, here is how you can create a "News" widget and > an "Issues Spotlight" widget and update those widgets accordingly.
>
> #### Add News and Resource Categories
> 1. Go to *"Posts"* -> *"Categories"*
> 2. Add two new categories:
>  * News
>  * Resources
> 3. Add a new post (*"News"* -> *"Add New"*) with the category "News". The text and title can be whatever you want - this is just a sample post so that you can see the template working when you add a "News" widget. This post can be deleted later.
> 4. Add a new Post (*"News"* -> *"Add New"*) with the category "Resources". The text and title can again be whatever you want - and can be deleted later. You need this post so that you can configure the Issues Spotlight widget later in the process.
>
> #### Adding "News" to the Homepage
> 1. Go to *"Appearance"* -> *"Widgets"*
> 2. Find the "Sidebar Home"
> 3. Drag and drop *Category Posts Widget*
> 4. Enter:
>  * Category = "News"
>  * Number of posts
>  * Sort by "Date"
>  * Show Post Excerpt
>  * Show post thumbnail.
> 5. Save the widget.
>
> #### Adding "Issues Spotlight" to the Homepage
> 1. Go to *Appearance -> Widgets*
> 2. Find the "Sidebar Home"
> 3. Drag and drop *Category Posts Widget*
> 4. Enter:
>  * "Issues Spotlight" as title
>  * Category = "Resources"
>  * Number of posts
>  * Sort by "Date"
>  * Show Post Excerpt
>  * Show post thumbnail.
>  * If using the Home Right Widget Area, set the Thumbnail width = 128 (leave height blank)
> 5. Save the widget.
>
> #### Adding News
> 1.  From the left-hand column, find the News section and click Edit or Add New
> 2.  Create or edit a post
> 3.  Assign it to the "News" category.
> 4.  Save or Publish
>
> #### Adding Issues Spotlight
> 1.  From the left-hand column, find the Posts section and click Edit or Add New
> 2.  Create or edit a post
> 3.  Add an Excerpt, which is visible on the home page.
> 4.  Assign it to the "Resources" category.
> 5.  Add a Featured Image, if applicable. Image should be sized to 128px x 80px
> 6.  Save or Publish

------------------------------------------------------------------------

<a name="05-eventsmanagerplugin"></a>
## Using the Events Manager Plugin ##
------------------------------

If you are not already using an events management plugin, this theme has been tested with the Events Manager plugin available here:
* [Events Manager WordPress.org page](https://wordpress.org/plugins/events-manager/)
* [Events Manager main site](http://wp-events-plugin.com/)

The second link for the main site includes documentation and tutorials that go into the many capabilities offered by this plugin.

### Adding Events
Within the theme, adding an event involves this process:

1. From the left-hand column, find the Events section and click Edit or Add New
2. Add Name
3. Add Event date
4. Add Event time
5. Enter Location information
6. Enter Details
7. Upload Event image
8. Submit Event
9. Events will need to be approved before going live. To approve an event, click on Events, click on highlighted event and select "approve" or "disapprove".

### Adding an Event Widget to the Sidebar
1. Go to *"Appearance"* -> *"Widgets"*
2. Find the "Sidebar Home" (only visible on the homepage) or "Sidebar" (visible on all the other pages) Area.
3. Drag and Drop the *Events Widget*
4. Set the title, number of events to show, order, etc.
5. Save the widget.

------------------------------------------------------------------------

<a name="06-childtheme"></a>
## Using a Child Theme For Customization ##
------------------------------

If you want to make deeper changes to the ISOC WordPress theme than what you can do using the widgets, menus and theme admin panels, the *safest* option is to create what is called a "child theme." Essentially, this is a separate theme that you apply to your site that references the ISOC theme and only includes whatever files from the original theme you want to modify.

For instance, if you wanted to make further changes to the header of the site, you might create a child theme that included only two files:
* style.css
* header.php

All the other files and settings would be pulled from the main ISOC theme.

The beauty of this setup is that the main ISOC theme can be upgraded without affecting any deep customizations you have made.

More information about using child themes can be found here:
* <http://codex.wordpress.org/Child_Themes>

(**ACTION**: An example of a child theme should be provided for chapters to be able to simply take and use.)

------------------------------------------------------------------------

<a name="07-support"></a>
## Support / Questions ##
------------------------------

This WordPress theme is provided "as-is" for ISOC chapters and others to develop WordPress sites. While there are WordPress-savvy ISOC staff and volunteers able to assist, please understand that this assistance is not guaranteed to always be available. The best way to raise issues is to use the issue tracker found at:

> <https://github.com/InternetSociety/isoc2017-wp/issues>

The issues will be posted publicly and can be responded to be others working with the theme.

------------------------------------------------------------------------

<a name="08-contribute"></a>
## Contributors and Contributing Changes ##
------------------------------

If you are familiar with modifying WordPress themes and want to make a direct contribution of code changes, we certainly welcome such contributions. You can either:

1. [Raise an issue in the issue tracker](https://github.com/InternetSociety/isoc2017-wp/issues) and include your code in that issue.

2. If you are familiar with how Github works, you can fork the repository, commit your changes and issue a pull request.

To date, the following people or organizations have contributed to this theme:

* Occhio BV, Amsterdam

The original implementation of the theme was performed for the Internet Society Chapter Netherlands.

------------------------------------------------------------------------

Thank you for using this WordPress theme - please do offer suggestions and feedback through the issue tracker. Thank you.

This theme is licensed for usage under the terms of the GPL v2.0. See the file ["license.txt"](/occhiobv/isoc/blob/master/license.txt) for more information.

*Copyright 2017 Internet Society*# isoc2017-wp
