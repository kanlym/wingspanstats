<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SolarSystem Entity
 *
 * @property string $name
 * @property int $solar_system_id
 *
 * @property \App\Model\Entity\SolarSystem $solar_system
 */
class SolarSystem extends Entity
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
        'solar_system_id' => false
    ];
}
