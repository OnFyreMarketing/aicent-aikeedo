Plugins & Themes
Building Plugins for Aikeedo
Learn how to create custom plugins to extend Aikeedo’s functionality and tailor your platform to your specific needs.

Plugins are powerful tools that allow you to enhance and customize your Aikeedo platform. This guide will walk you through the process of building a plugin, using a simple Currency Beacon integration as an example.

​
What are Aikeedo Plugins?
Aikeedo plugins are Composer packages that extend the functionality of your platform. They allow you to:

Add new features
Integrate with third-party services
Customize existing functionality
Plugins give you the flexibility to tailor Aikeedo to your specific requirements without modifying the core codebase.

​
Prerequisites
Before you begin, make sure you have:

Basic knowledge of PHP and Composer
A local development environment set up for Aikeedo
Composer installed on your system
If you need help setting up your local environment, refer to our Local Development Guide.

​
Step-by-Step Plugin Creation
Let’s create a plugin that integrates CurrencyBeacon as an alternative currency rate provider for your Aikeedo platform.

​
Step 1: Create the Plugin Directory
First, create a new directory for your plugin in the /public/content/plugins folder of your Aikeedo installation:


Copy
mkdir -p extra/extensions/aikeedoplugins/cost-preview-plugin
Die Verzeichnisstruktur sollte dem Format folgen: `extra/extensions/yourorganization/plugin-name`. Diese Namenskonvention hilft bei der Identifizierung und Organisation von Plugins.

​
Step 2: Create the composer.json File
Every Aikeedo plugin requires a composer.json file. This file contains essential metadata about your plugin.

Create a composer.json file in your plugin directory with the following content:


Copy
{
  "name": "aicent/cost-preview-plugin",
  "type": "aikeedo-plugin",
  "version": "1.0.0",
  "require": {
    "heyaikeedo/composer": "^1.0.0"
  },
  "extra": {
    "entry-class": "Aicent\\CostPreviewPlugin\\Plugin"
  },
  "autoload": {
    "psr-4": {
      "Aicent\\CostPreviewPlugin\\": "src/"
    }
  }
}
Let’s break down the important parts of this file:

name: Muss mit dem Pfad zu Ihrem Plugin-Verzeichnis übereinstimmen (`aicent/cost-preview-plugin` innerhalb von `extra/extensions/`)
type: Always set to aikeedo-plugin for Aikeedo plugins
version: Defines the current version of your plugin
require: Lists the dependencies, including the required heyaikeedo/composer package
extra.entry-class: Specifies the main class of your plugin
autoload: Sets up PSR-4 autoloading for your plugin’s classes
The heyaikeedo/composer package is required for all Aikeedo plugins. It provides essential functionality for plugin integration.

​
Step 3: Create the Plugin Class
Now, let’s create the main plugin class. This class will be responsible for initializing your plugin’s functionality.

Create a file named Plugin.php in the src directory of your plugin:


Copy
<?php

declare(strict_types=1);

namespace AikeedoPlugins\CostPreviewPlugin;

use Override;
use Plugin\Domain\Context;
use Plugin\Domain\PluginInterface;

class Plugin implements PluginInterface
{
    #[Override]
    public function boot(Context $context): void
    {
        // Plugin initialization code goes here
        // For a complete implementation example, visit:
        // https://github.com/heyaikeedo/plugins-currency-beacon
    }
}
This class implements the PluginInterface, which requires a boot method. The boot method is called when your plugin is loaded by Aikeedo, allowing you to set up any necessary functionality.

​
Step 4: Install the Plugin
With your plugin structure in place, you can now install it using Composer. Run the following command in the root directory of your Aikeedo installation:


Copy
composer require aikeedoplugins/cost-preview-plugin
This command installs your plugin and its dependencies.

​
Step 5: Enable the Plugin
After installation, you’ll need to enable your plugin through the Aikeedo dashboard. Look for the “Plugins” section in your admin panel to activate your new plugin.

​
Best Practices and Tips
Version Control: Use Git or another version control system to track changes to your plugin.

Updates: Regularly update your plugin to maintain compatibility with the latest Aikeedo version.