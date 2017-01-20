<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AgentKill Entity
 *
 * @property int $id
 * @property int $character_id
 * @property int $kill_id
 * @property bool $killingBlow
 * @property float $damageDone
 * @property int $ship_type_id
 * @property int $corporation_id
 *
 * @property \App\Model\Entity\Character $character
 * @property \App\Model\Entity\Kill $kill
 */
class AgentKill extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
