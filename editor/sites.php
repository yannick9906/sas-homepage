<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.01.2016
 * Time: 15:32
 */

if($user->isActionAllowed(PERM_SITE_VIEW)) {
    $pgdata = getEditorPageDataStub("Seiten", $user);
    $entries = \ICMS\TimelineEntry::getAllEntries();
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
        $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_TIMELINE_OP_DELETE);
        $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_TIMELINE_APPROVE);
    }

    $dwoo->output("tpl/sitesList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}