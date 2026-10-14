<?php

namespace NoTP\NoTP;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\Command\ConsoleCommandSender;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Main extends PluginBase implements Listener {

	private $enabled;

	public function onEnable() {
		$this->enabled = [];
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->dispatchCommand(new ConsoleCommandSender(), 'setgperm Guest notp.command');
	}

	public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args) {
		if ((strtolower($cmd->getName()) == 'notp') && !(isset($args[0])) && ($issuer instanceof Player) && ($issuer->hasPermission('notp.command') || $issuer->hasPermission('notp.command.other'))) {
			if (isset($this->enabled[strtolower($issuer->getName())])) {
				unset($this->enabled[strtolower($issuer->getName())]);
			} else {
				$this->enabled[strtolower($issuer->getName())] = strtolower($issuer->getName());
			}

			if (isset($this->enabled[strtolower($issuer->getName())])) {
				$issuer->sendMessage('§l§c[§eNoTP§c]§b Chế Độ §eNoTP§b Đã §aBật');
			} else {
				$issuer->sendMessage('§l§c[§eNoTP§c]§b Chế Độ §eNoTP§b Đã §cTắt');
			}
			return true;
		} else {
			return false;
		}
	}
	public function onPlayerCommand(PlayerCommandPreprocessEvent $event) {

		$message = $event->getMessage();
		if (strtolower(substr($message, 0, 3) === '/tp')) {
			$command = substr($message, 1);
			$args = explode(' ', $command);
			if (!isset($args[1])) {
				return;
			}
			$sender = $event->getPlayer();

			foreach ($this->enabled as $notpuser) {

				if ((strpos(strtolower($notpuser), strtolower($args[1])) !== false) && (strtolower($notpuser) !== strtolower($sender->getName()))) {
					$sender->sendMessage('§l§c[§eNoTP§c]§b Người Này Hiện Đang§a Bật§b Chế Độ §eNoTP');
					$event->setCancelled(true);
					return;
				}

				if (isset($args[2]) && strpos(strtolower($notpuser), strtolower($args[2])) !== false && (strtolower($notpuser) !== strtolower($sender->getName()))) {
					$sender->sendMessage('§l§c[§eNoTP§c]§b Người Này Hiện Đang§a Bật§b Chế Độ §eNoTP');
					$event->setCancelled(true);
					return;
				}
			}
		}
	}
}
