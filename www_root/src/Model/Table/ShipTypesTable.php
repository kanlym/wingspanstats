<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShipTypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ShipTypes
 *
 * @method \App\Model\Entity\ShipType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShipType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShipType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShipType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShipType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShipType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShipType findOrCreate($search, callable $callback = null, $options = [])
 */
class ShipTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('ship_types');
        $this->displayField('name');
        $this->primaryKey('ship_type_id');

        $this->belongsTo('ShipTypes', [
            'foreignKey' => 'ship_type_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['ship_type_id'], 'ShipTypes'));

        return $rules;
    }
}
