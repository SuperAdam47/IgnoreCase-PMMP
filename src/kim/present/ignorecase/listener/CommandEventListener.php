<?php

/*
 *
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  PresentKim (debe3721@gmail.com)
 * @link    https://github.com/PresentKim
 * @license https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0.0
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace kim\present\ignorecase\listener;

use kim\present\ignorecase\IgnoreCase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\{
	RemoteServerCommandEvent, ServerCommandEvent
};

class CommandEventListener implements Listener{
	/** @var IgnoreCase */
	private $plugin;

	/**
	 * CommandEventListener constructor.
	 *
	 * @param IgnoreCase $plugin
	 */
	public function __construct(IgnoreCase $plugin){
		$this->plugin = $plugin;
	}

	/**
	 * @priority LOWEST
	 *
	 * @param PlayerCommandPreprocessEvent $event
	 */
	public function onPlayerCommandPreprocessEvent(PlayerCommandPreprocessEvent $event) : void{
		if(strpos($message = $event->getMessage(), "/") === 0){
			$event->setMessage("/{$this->plugin->replaceCommand(substr($message, 1))}");
		}
	}

	/**
	 * @priority LOWEST
	 *
	 * @param ServerCommandEvent $event
	 */
	public function onServerCommandEvent(ServerCommandEvent $event) : void{
		$event->setCommand($this->plugin->replaceCommand($event->getCommand()));
	}

	/**
	 * @priority LOWEST
	 *
	 * @param RemoteServerCommandEvent $event
	 */
	public function onRemoteServerCommandEvent(RemoteServerCommandEvent $event) : void{
		$this->onServerCommandEvent($event);
	}
}
