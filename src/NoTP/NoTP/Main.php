<?php

declare(strict_types=1);

namespace NoTP\NoTP;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

final class Main extends PluginBase implements Listener{
	/** @var array<string, string> Lowercase player name mapped to its display name */
	private array $enabled = [];

	protected function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if(strtolower($command->getName()) !== "notp" || $args !== [] || !$sender instanceof Player || !$sender->hasPermission("notp.command")){
			return false;
		}

		$key = strtolower($sender->getName());
		if(isset($this->enabled[$key])){
			unset($this->enabled[$key]);
			$sender->sendMessage(TextFormat::BOLD . TextFormat::RED . "[" . TextFormat::YELLOW . "NoTP" . TextFormat::RED . "]" . TextFormat::AQUA . " Chế độ NoTP đã tắt");
		}else{
			$this->enabled[$key] = $sender->getName();
			$sender->sendMessage(TextFormat::BOLD . TextFormat::RED . "[" . TextFormat::YELLOW . "NoTP" . TextFormat::RED . "]" . TextFormat::AQUA . " Chế độ NoTP đã bật");
		}

		return true;
	}

	public function onCommandEvent(CommandEvent $event) : void{
		$sender = $event->getSender();
		if(!$sender instanceof Player || $this->enabled === []){
			return;
		}

		$commandLine = trim($event->getCommand());
		$parts = preg_split('/\s+/', $commandLine, 3);
		if(!is_array($parts) || !isset($parts[0])){
			return;
		}

		$command = $this->getServer()->getCommandMap()->getCommand(strtolower($parts[0]));
		if($command === null || !TeleportCommandPolicy::shouldBlock($commandLine, array_values($this->enabled), $sender->getName(), $command->getName())){
			return;
		}

		$event->cancel();
		$sender->sendMessage(TextFormat::BOLD . TextFormat::RED . "[" . TextFormat::YELLOW . "NoTP" . TextFormat::RED . "]" . TextFormat::AQUA . " Người chơi này đang bật chế độ NoTP");
	}
}
