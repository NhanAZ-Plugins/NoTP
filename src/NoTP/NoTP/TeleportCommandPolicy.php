<?php

declare(strict_types=1);

namespace NoTP\NoTP;

final class TeleportCommandPolicy{
	private const TELEPORT_COMMANDS = ["tp", "teleport"];

	/** @param list<string> $protectedPlayerNames */
	public static function shouldBlock(
		string $commandLine,
		array $protectedPlayerNames,
		string $senderName,
		?string $resolvedCommandName = null
	) : bool{
		$parts = preg_split('/\s+/', trim($commandLine), 3);
		if(!is_array($parts) || $parts === []){
			return false;
		}

		$command = strtolower($resolvedCommandName ?? ltrim($parts[0], "/"));
		if(!in_array($command, self::TELEPORT_COMMANDS, true)){
			return false;
		}

		$sender = strtolower($senderName);
		$protected = [];
		foreach($protectedPlayerNames as $name){
			$protected[strtolower($name)] = true;
		}
		if(isset($protected[$sender])){
			return false;
		}

		$arguments = array_slice($parts, 1, 2);
		foreach($arguments as $argument){
			if(isset($protected[strtolower($argument)])){
				return true;
			}
		}
		return false;
	}
}
