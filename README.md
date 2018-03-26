# SiteMode Module for Magento 1

A hassle free magento 1 module for putting your store in either maintenance, coming soon or live mode.
Running multiple storefronts on your magento installation? This module takes that into consideration and you could easily put any of your storefronts in any of the pre-defined modes.

This module by default, ships with two (2) different maintenance mode and one (1) coming soon mode customizable templates.
Ofcourse, you could choose to create may more as you see fit.

To customize the default templates or add new ones, goto:
`Hatmeige -> Site Mode -> Template`

Note: The templates can be scoped to a particular store view.

## Configuration & Setup
By default, this module ships with the storefronts on live mode so you don't get undesired results.
To put your storefronts in either maintenance or coming soon mode, goto: `Hatmeige -> Site Mode -> Settings` and you should be greeted with a view like this:

![Alt text](media/sitemode/modes.png?raw=true "Mode Selection")

### live mode
Click on the `Activate` button to set this mode for the current scope.
In this mode, your storefront is accessible to anyone. This essentially is the default state of any magento store.


### maintenance mode / group configuration
Click on the `Activate` button to set this mode for the current scope.
In this mode, your storefront is put on maintenance and only accessible to the whitelisted IPs (IPs entered in the `Allowed IP addresses` field).

In maintenance mode, the storefront uses additional settings that may be found in the `Maintenance Mode` group.
```
Launching Date: The date the store would be put back in live mode

Launching Time: The time of the day the site should be put on live mode.

Page Layout: Select one of three (3) default available templates. The store front displays this layout as the template seen while in maintenance mode

Display Countdown Timer: Should countdown timer be displayed? This makes use of the launch date & time.

Display Subscribe Form: Should customers be allowed to subscribe to newsletter?

Display Social Share Buttons: Should customers be shown the social links? Makes use of the links entered in the 'Social' group.
```

![Alt text](media/sitemode/maintenance.png?raw=true "Maintenance Mode Group")

#### maintenance mode activated
When `Maintenance Layout 1` is selected as the `Page Layout`:

![Alt text](media/sitemode/maintenance-mode.png?raw=true "Maintenance Mode")

When `Maintenance Layout 2` is selected as the `Page Layout`:

![Alt text](media/sitemode/maintenance-mode-2.png?raw=true "Maintenance Mode")


### coming soon mode / group configuration
Click on the `Activate` button to set this mode for the current scope.
In this mode, your storefront is put on coming soon mode and only accessible to the whitelisted IPs (IPs entered in the `Allowed IP addresses` field).

In coming soon mode, the storefront uses additional settings that may be found in the `Coming Soon Mode` group.
```
Launching Date: The date the store would be put back in live mode

Launching Time: The time of the day the site should be put on live mode.

Page Layout: Select one of three (3) default available templates. The store front displays this layout as the template seen while in maintenance mode

Display Countdown Timer: Should countdown timer be displayed? This makes use of the launch date & time.

Display Subscribe Form: Should customers be allowed to subscribe to newsletter?

Display Social Share Buttons: Should customers be shown the social links? Makes use of the links entered in the 'Social' group.
```

![Alt text](media/sitemode/coming.png?raw=true "Coming Soon Mode Group")

#### coming soon mode activated
When `Coming Soon` is selected as the `Page Layout`:

![Alt text](media/sitemode/coming-mode.png?raw=true "Coming Soon Mode")


### social group configuration
If you choose to display social links in either maintenance or coming soon mode, you should enter links to your social accounts here.

![Alt text](media/sitemode/social.png?raw=true "Social Group")
