# BeestFeest RAGweek plugin
A [WordPress](https://wordpress.com/) plugin for the [BeestFeest](https://beestfeest.com/) website that enables it to display requested songs and notification on a webpage. This plugin was created for the [RAGweek](https://ragweeknijmegen.nl/) BeestFeest in which visitors can request songs by donating to the RAGweek. The requested songs will then show up on the special webpage.

## Installation
Upload the plugin directory (`beestfeest-ragweek-plugin`) to the plugins folder (`wp-content/plugins`) on the WordPress installation. After that, activate the plugin within the WordPress administrator dashboard.

## Usage
There are three steps needed for getting the plugin to work:

1. The plugin shortcode needs to be put on at least one page.
2. RAGweek manager accounts need to be created.
3. Songs and notifications need to be put into the plugin.

### Putting the shortcode on a page
The first step is to put the plugin shortcode (`[bfrw-ragweek]`) on one of the pages or posts. Note that the entire page content will get overwritten by the shortcode (e.g. the page template will get overwritten by the plugin). All `<head>` elements will remain as they are. Sometimes styles from the WordPress installation might interfere with the elements used by the plugin shortcode. These interferences can be fixed by using the site's customizer and adding some custom CSS.

### Adding RAGweek manager accounts
There are two WordPress roles that can access the custom post types created by the plugin. These roles are the `administrator` and the `RAGweek manager`. `RAGweek manager`s are also only able to edit these custom post types, nothing else. It is thus useful to create `RAGweek manager` accounts for everyone that should only be able to access the requested songs and the notifications. Usually the DJs and the RAGweek staff get a `RAGweek manager` account.

### Adding songs and notifications
After activating the plugin, two new custom post types will show up. One called 'Requested songs' and another called 'Notifications'. These custom post types will show up on the RAGweek page created in step 1. Adding a notification will show the notification text at the bottom of the RAGweek page. Adding a song with a specific price will put it in the list (sorted on highest price) on the RAGweek page.

To remove an item from either the song list or the notifications, you can just delete the post created under the custom post type corresponding to the item.