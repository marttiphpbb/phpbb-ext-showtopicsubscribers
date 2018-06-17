# phpBB Extension - marttiphpbb Show Topic Subscribers

[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2476106)

## Features

* Shows the subscribers of a topic
* A threshold can be defined in ACP of the maximum number of subscribers to be shown. Above this number only the number is shown. (To be set if there is a  performance issue).

## Requirements

* phpBB 3.2.1+
* PHP 7+

## Quick Install

You can install this on the latest release of phpBB 3.2 by following the steps below:

* Create `marttiphpbb/showtopicsubscribers` in the `ext` directory.
* Download and unpack the repository into `ext/marttiphpbb/showtopicsubscribers`
* Enable `Show Topic Subscribers` in the ACP at `Customise -> Manage extensions`.

## Uninstall

* Disable `Show Topic Subscribers` in the ACP at `Customise -> Extension Management -> Extensions`.
* To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/showtopicsubscribers` directory.

## Support

* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-showtopicsubscribers/issues).

## License

[GPL-2.0](license.txt)

## Screenshots

### ACP

![ACP](doc/acp.png)

### Viewtopic

![List](doc/list.png)
