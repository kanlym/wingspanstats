<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Victim Entity
 *
 * @property int $id
 * @property int $character_id
 * @property int $ships_lost
 * @property float $isk_lost
 *
 * @property \App\Model\Entity\Character $character
 */
class Victim extends Entity
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
