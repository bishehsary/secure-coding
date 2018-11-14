<?php

namespace FW\App;


class Acl
{
    const POLICY_DENY = 0;
    const POLICY_ALLOW = 1;

    private static $roles = [[], []];
    private static $defaultPolicy = Acl::POLICY_DENY;

    static function addRole($role)
    {
        self::$roles[$role] = [[], []];
    }

    static function setDefaultPolicy($policy)
    {
        self::$defaultPolicy = $policy == self::POLICY_ALLOW ? self::POLICY_ALLOW : self::POLICY_DENY;
    }

    static function allow($role, $resource, $action)
    {
        self::addPolicy($role, strtolower($resource), strtolower($action), self::POLICY_ALLOW);
    }

    static function deny($role, $resource, $action)
    {
        self::addPolicy($role, strtolower($resource), strtolower($action), self::POLICY_DENY);
    }

    private static function addPolicy($role, $resource, $action, $policy)
    {
        if (!isset(self::$roles[$role][$policy][$resource])) {
            self::$roles[$role][$policy][$resource] = [];
        }
        if (array_search($action, self::$roles[$role][$policy][$resource]) === false) {
            self::$roles[$role][$policy][$resource][] = $action;
        }
    }

    static function isAllowed($role, $resource, $action)
    {
        if (!isset(self::$roles[$role])) return self::$defaultPolicy;
        $roles = self::$roles[$role];
        if (self::$defaultPolicy == self::POLICY_ALLOW) {
            foreach ($roles[self::POLICY_DENY] as $r => $actions) {
                if ($r == $resource || $r == '*') {
                    if (array_search('*', $actions) !== false || array_search($action, $actions) !== false) {
                        return false;
                    }
                }
            }
            return true;
        }
        foreach ($roles[self::POLICY_ALLOW] as $r => $actions) {
            if ($r == $resource || $r == '*') {
                if (array_search('*', $actions) !== false || array_search($action, $actions) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}