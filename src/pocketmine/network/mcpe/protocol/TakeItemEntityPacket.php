<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>


use pocketmine\network\mcpe\handler\PacketHandler;

class TakeItemEntityPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::TAKE_ITEM_ENTITY_PACKET;

	/** @var int */
	public $target;
	/** @var int */
	public $eid;

	public static function create(int $takerEntityRuntimeId, int $itemEntityRuntimeId) : self{
		$result = new self;
		$result->target = $itemEntityRuntimeId;
		$result->eid = $takerEntityRuntimeId;
		return $result;
	}

	protected function decodePayload() : void{
		$this->target = $this->getEntityRuntimeId();
		$this->eid = $this->getEntityRuntimeId();
	}

	protected function encodePayload() : void{
		$this->putEntityRuntimeId($this->target);
		$this->putEntityRuntimeId($this->eid);
	}

	public function handle(PacketHandler $handler) : bool{
		return $handler->handleTakeItemEntity($this);
	}
}
