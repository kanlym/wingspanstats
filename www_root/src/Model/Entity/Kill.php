<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Kill Entity
 *
 * @property int $character_id
 * @property int $ship_type_id
 * @property int $solar_system_id
 * @property \Cake\I18n\Time $date
 * @property float $value
 * @property int $kill_id
 * @property int $agent_id
 * @property float $totalWingspanPct
 *
 * @property \App\Model\Entity\Character $character
 * @property \App\Model\Entity\ShipType $ship_type
 * @property \App\Model\Entity\SolarSystem $solar_system
 * @property \App\Model\Entity\Kill $kill
 */
class Kill extends Entity
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
        'kill_id' => false
    ];
}
