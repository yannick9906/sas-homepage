<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 26.11.2015
 * Time: 17:18
 */

namespace ICMS;


define("PERM_DB_LOGIN", "admin.database");

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

define("PERM_NEWS_CREATE", "news.create");
define("PERM_NEWS_VIEW", "news.view");
define("PERM_NEWS_APPROVE", "news.approve");
define("PERM_NEWS_NEW_VERSION", "news.newVersion");
define("PERM_NEWS_OP_DELETE", "admin.news.del");
define("PERM_NEWS_OP_EDIT", "admin.news.edit");

define("PERM_PROTOCOLS_CREATE", "protocols.create");
define("PERM_PROTOCOLS_VIEW", "protocols.view");
define("PERM_PROTOCOLS_APPROVE", "protocols.approve");
define("PERM_PROTOCOLS_NEW_VERSION", "protocols.newVersion");
define("PERM_PROTOCOLS_OP_DELETE", "admin.protocols.del");
define("PERM_PROTOCOLS_OP_EDIT", "admin.protocols.edit");

define("PERM_FILE_CREATE", "file.create");
define("PERM_FILE_VIEW", "file.view");
define("PERM_FILE_OP_DELETE", "admin.file.del");
define("PERM_FILE_OP_EDIT", "admin.file.edit");

define("PERM_SITE_CREATE", "site.create");
define("PERM_SITE_VIEW", "site.view");
define("PERM_SITE_APPROVE", "site.approve");
define("PERM_SITE_NEW_VERSION_OWN", "site.newVersionOwn");
define("PERM_SITE_NEW_VERSION_ALL", "site.newVersionAll");
define("PERM_SITE_OP_DELETE", "admin.site.del");
define("PERM_SITE_OP_EDIT", "admin.site.edit");