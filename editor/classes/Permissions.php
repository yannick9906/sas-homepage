<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 26.11.2015
 * Time: 17:18
 */

namespace ICMS;

define("PERM_USER_DELETE", "users.del");
define("PERM_USER_EDIT",   "users.edit");
define("PERM_USER_CREATE", "users.create");
define("PERM_USER_VIEW", "users.view");
define("PERM_USER_EDIT_PERMISSIONS", "users.perms");

define("PERM_TIMELINE_CREATE", "timeline.create");
define("PERM_TIMELINE_VIEW", "timeline.view");
define("PERM_TIMELINE_APPROVE", "timeline.approve");
define("PERM_TIMELINE_NEW_VERSION", "timeline.newVersion");
define("PERM_TIMELINE_OP_DELETE", "admin.timeline.del");
define("PERM_TIMELINE_OP_EDIT", "admin.timeline.edit");

define("PERM_SITE_CREATE", "sites.create");
define("PERM_SITE_VIEW", "sites.view");
define("PERM_SITE_APPROVE", "sites.approve");
define("PERM_SITE_NEW_VERSION", "sites.newVersion");
define("PERM_SITE_OP_DELETE", "admin.sites.del");
define("PERM_SITE_OP_EDIT", "admin.sites.edit");