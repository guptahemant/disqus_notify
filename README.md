CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Installation
 * MODULE FEATURES
 * Configuration
 * Debugging
 * Maintainers


INTRODUCTION
------------
This module extends the disqus module by providing a functionality to send
emails to node authors when a comment is posted on their content.This module
uses "onNewComment" event triggered from Disqus to send the notification mails
to node author.

REQUIREMENTS
------------

This module depends on Disqus module(https://drupal.org/project/disqus).


INSTALLATION
------------

Install as you would normally install a contributed Drupal module. See:
https://drupal.org/documentation/install/modules-themes/modules-8 for further
information.

MODULE FEATURES
---------------
 * This module provides a simple configuration to enable sending the mails and
   to configure email content.
 * This module supports use of tokens in email content.

CONFIGURATION
-------------

 * After installing, go to: admin/config/services/disqus-notify

 * Enable the notify checkbox and configure the email content.

DEBUGGING
---------
* Clear the drupal cache for changes to take affect.


MAINTAINERS
-----------

Current maintainers:
 * Hemant Gupta (https://www.drupal.org/u/guptahemant)
