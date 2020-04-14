<?php
namespace Deceitya\Particlecle;

use pocketmine\plugin\PluginBase;
use pocketmine\level\particle\DustParticle;
use flowy\Flowy;
use function flowy\standard\delay;

class Main extends PluginBase
{
    public function onEnable()
    {
        require_once "{$this->getFile()}vendor/autoload.php";

        mt_srand();

        Flowy::run($this, function () {
            $original = $this->getServer()->getDefaultLevel()->getSafeSpawn();
            $level = $original->getLevel();
            while (true) {
                $y = 0;
                for ($rad = 0; $rad < 4 * M_PI; $rad += M_PI / 18) {
                    $level->addParticle(new DustParticle($original->add(sin($rad), $y, cos($rad)), mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));
                    $level->addParticle(new DustParticle($original->add(sin($rad + M_PI), $y, cos($rad + M_PI)), mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));

                    $y += 0.04;

                    yield from delay($this->getScheduler(), 1);
                }
            }
        });
    }
}
