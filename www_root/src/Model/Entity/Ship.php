<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ship Entity
 *
 * @property int $id
 * @property int $ship_type_id
 * @property int $ships_destroyed
 * @property float $isk_destroyed
 *
 * @property \App\Model\Entity\ShipType $ship_type
 */
class Ship extends Entity
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
