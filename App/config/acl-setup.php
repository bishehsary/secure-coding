<?php
use FW\App\Acl;

Acl::setDefaultPolicy(Acl::POLICY_ALLOW);
//
//Acl::addRole('agent');
//Acl::allow('agent', 'index', '*');
//
//Acl::addRole('admin');
//Acl::allow('admin', '*', '*');