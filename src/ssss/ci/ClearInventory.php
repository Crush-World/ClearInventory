<?php

namespace ssss\ci;

use name\uimanager\event\ModalFormResponseEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use name\uimanager\CustomForm;
use name\uimanager\element\Toggle;
use name\uimanager\element\Label;
use name\uimanager\UIManager;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\command\CommandSender;

class ClearInventory extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getServer()
            ->getPluginManager()
            ->registerEvents($this, $this);
        \o\c\c::command("ci", "인벤토리를 초기화합니다.", "/ci", [], function (CommandSender $sender, string $commandLabel, array $args) {
            if ($sender instanceof Player)
                ClearInventory::sendUI($sender);
        });
    }

    public function r(ModalFormResponseEvent $e)
    {
        $formId = $e->getFormId();
        if ($formId === 1747224) {
            $formData = $e->getFormData();
            if ($formData !== null) {
                if (isset($formData[1])) {
                    if ($formData[1]) {
                        $pl = $e->getPlayer();
                        $pl->getInventory()->clearAll();
                        $pl->sendMessage("§l§b[알림] §r§7인벤토리를 초기화했습니다.");
                    }
                }
            }
        }

    }

    public static function sendUI(Player $player)
    {
        $form = new CustomForm("§l인벤토리 초기화");
        $form->addElement(new Label("이 기능으로 인한 인벤토리 초기화시 발생하는 문제에 대한 모든 책임은 본인에게 있습니다."));
        $form->addElement(new Toggle("체크시 인벤토리 초기화에 동의합니다."));
        UIManager::getInstance()->sendUI($player, $form, 1747224);
    }
}