## Lock Plugins

A simple WordPress plugin that allows developers to prevent other plugins from updating.

Inspiration: https://twitter.com/danielbachhuber/status/768907891294121984

### Usage

Chances are you'd want to put this plugin to be a [Must Use Plugin](https://codex.wordpress.org/Must_Use_Plugins), to prevent it from being disabled.

Then in another plugin, use the following filter to add your list of plugins that should not look for updates.

```php
add_filter('lock_plugins-locked_plugins', function($plugins){
  $plugins[] = 'akismet/akismet.php';

  return $plugins;
});
```

