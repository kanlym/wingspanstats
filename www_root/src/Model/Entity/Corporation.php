<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Corporation Entity
 *
 * @property int $corporation_id
 * @property string $corporation_name
 *
 * @property \App\Model\Entity\Corporation $corporation
 */
class Corporation extends Entity
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
        'corporation_id' => false
    ];
}
