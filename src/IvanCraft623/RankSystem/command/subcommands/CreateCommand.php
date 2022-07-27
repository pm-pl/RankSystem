<?php

declare(strict_types=1);

namespace IvanCraft623\RankSystem\command\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;

use IvanCraft623\RankSystem\RankSystem;
use IvanCraft623\RankSystem\rank\RankModifier;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;

final class CreateCommand extends BaseSubCommand {

	public function __construct(private RankSystem $plugin) {
		parent::__construct("create", "Create a Rank");
		$this->setPermission("ranksystem.command.create");
	}

	protected function prepare() : void {
		$this->registerArgument(0, new RawStringArgument("rank"));
		$this->addConstraint(new InGameRequiredConstraint($this));
	}

	/**
	 * @param Player $sender
	 */
	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void {
		if ($this->plugin->getRankManager()->exists($args["rank"])) {
			$sender->sendMessage("§c" . $args["rank"] . " rank already exist!");
		} else {
			new RankModifier($sender, $args["rank"]);
		}
	}

	public function getParent() : BaseCommand {
		return $this->parent;
	}
}