<?php

namespace OCA\PkDrive\Component;

/**
 * Class TargetType Copy from TargetType in flexapps
 * @package OCA\PkDrive\Component
 */
class TargetType
{
    const PROJECT = 0;
	const TASK = 1;
	const ISSUE = 2;
	const RESOURCE = 3;
	const CALENDAR_ITEM = 4;
	const USER = 5;
    const POST = 6;
	const TASK_RESOURCE_ASSIGNMENT = 7;
	const UNKNOWN = -1;
}