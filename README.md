Data Generator
==============

Elgg plugin that allows to fill-up your installation with a lot of fake data.
It's meant for benchmarking your installation on high volumes of data. **Do not use on production sites!**

Usage
-----

For smaller amounts of data, you may use page in admin panel. Go to *Develop* -> *Data Generator* in admin panel.

For large amount of data, you need to use command line interface. To do so, go to plugin directory (`mod/data_generator`)
and call `php cli_run.php` with proper parameters. To see available parameters, run `php cli_run.php --help`. It will output following
information:

	Usage: cli_run.php [OPTIONS]

	Options are:
	-a N, --amount N	Sets N as amount of items to generate. Required.

	-p P, --profile P	Sets P as chosen profile that determines type of items
				to generate. Run without value to get list of possible
				values. Required.

	-l L, --locale L	Sets L as localization of generated content. Some
				of valid options may not be fully supported. Run
				without value to get list of possible values. Required.

	-h, --help		Outputs this help info.

Please consider locales other than en_\* as experimental.

Profiles
--------

Currently implemented data generation scenarios (called "profiles") are:

* **newUserEntity** - generates new ElggUser entities with filled profile data as in vanilla Elgg install
* **usersRelationshipFriend** - creates friend relationsips between existing ElggUser entities
* **newBlogEntity** - generates new ElggBlog entities in various possible states that may be produced by bundled *blog* plugin
* **blogAnnotationRevision** - adds revision annotations to existing ElggBlog entities
* **blogAnnotationComment** - adds comment annotations to existing ElggBlog entities (that won't work correctly on elgg 1.9 that migrated comments from annotations to entities)

Known issues
------------
* Cyrylic usernames are not handled by the core and may not work correctly with common plugins. Use at your own risk.

