<?php

/*  PureEntitiesX: Mob AI Plugin for PMMP
    Copyright (C) 2017 RevivalPMMP

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>. */

namespace revivalpmmp\pureentities\task;


use pocketmine\entity\Living;
use pocketmine\scheduler\PluginTask;
use revivalpmmp\pureentities\entity\monster\walking\Enderman;
use revivalpmmp\pureentities\InteractionHelper;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\PureEntities;

/**
 * Class EndermanLookingTask
 *
 * As the name says:
 *
 * @package revivalpmmp\pureentities\task
 */
class EndermanLookingTask extends PluginTask {

    /**
     * @var PureEntities
     */
    private $plugin;

    private $isInteractiveButtonCorrectionSet = false;

    public function __construct(PureEntities $plugin) {
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->isInteractiveButtonCorrectionSet = PluginConfiguration::getInstance()->isInteractiveButtonCorrection();
    }

    /**
     * Called when the task is executed
     *
     * @param int $currentTick
     */
    public function onRun($currentTick) {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $entity = InteractionHelper::getEntityPlayerLookingAt($player, 64, $this->isInteractiveButtonCorrectionSet);
            PureEntities::logOutput("EndermanLookingTask: $player is looking at $entity", PureEntities::DEBUG);
            if ($entity !== null and $entity instanceof Enderman and !$entity->getBaseTarget() instanceof Living) { // player is looking at an enderman
                $entity->playerLooksAt($player);
            }
        }
    }


}