<?php

declare(strict_types=1);

require __DIR__ . "/../src/NoTP/NoTP/TeleportCommandPolicy.php";

use NoTP\NoTP\TeleportCommandPolicy;

$cases = [
	"blocks a protected target" => ["tp ProtectedPlayer", ["ProtectedPlayer"], "Visitor", "tp", true],
	"blocks a protected source" => ["teleport ProtectedPlayer Visitor", ["ProtectedPlayer"], "Visitor", "teleport", true],
	"matches player names without case sensitivity" => ["tp protectedplayer", ["ProtectedPlayer"], "Visitor", "tp", true],
	"does not match a name prefix" => ["tp ProtectedPlayerTwo", ["ProtectedPlayer"], "Visitor", "tp", false],
	"does not block the protected player" => ["tp Visitor", ["ProtectedPlayer"], "protectedplayer", "tp", false],
	"does not block unrelated commands" => ["say ProtectedPlayer", ["ProtectedPlayer"], "Visitor", "say", false],
	"does not block when a teleport alias resolves to tp" => ["tele ProtectedPlayer", ["ProtectedPlayer"], "Visitor", "tp", true],
	"does not treat arbitrary aliases as teleport commands" => ["tele ProtectedPlayer", ["ProtectedPlayer"], "Visitor", "tele", false],
];

foreach($cases as $name => [$commandLine, $protectedPlayers, $senderName, $resolvedCommandName, $expected]){
	$actual = TeleportCommandPolicy::shouldBlock($commandLine, $protectedPlayers, $senderName, $resolvedCommandName);
	if($actual !== $expected){
		fwrite(STDERR, "Failed: {$name}\n");
		exit(1);
	}
}

echo "Passed " . count($cases) . " teleport policy cases\n";
