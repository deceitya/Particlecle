<?php
namespace Deceitya\Particlecle;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\level\Position;
use pocketmine\level\particle\DustParticle;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->getScheduler()->scheduleRepeatingTask(new ClecleTask($this->getServer()->getDefaultLevel()->getSafeSpawn()), 2);
    }
}

class ClecleTask extends Task
{
    private $pos;
    private $h = 0.0;
    private $rad = 0;

    public function __construct(Position $pos)
    {
        $this->pos = $pos;
    }

    public function onRun(int $currentTick)
    {
        if ($this->h > 4.0) {
            $this->h = 0.0;
        }
        if ($this->rad >= 2 * M_PI) {
            $this->rad = 0;
        }

        $pos = $this->pos->add(sin($this->rad), $this->h, cos($this->rad));
        $pos2 = $this->pos->add(sin($this->rad + M_PI), $this->h, cos($this->rad + M_PI));
        $this->pos->level->addParticle(new DustParticle($pos, 255, 255, 255));
        $this->pos->level->addParticle(new DustParticle($pos2, 255, 255, 255));

        $this->h += 0.05;
        $this->rad += 0.174533;
    }
}
