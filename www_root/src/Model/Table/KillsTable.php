<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Kills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Characters
 * @property \Cake\ORM\Association\BelongsTo $ShipTypes
 * @property \Cake\ORM\Association\BelongsTo $SolarSystems
 * @property \Cake\ORM\Association\BelongsTo $Kills
 * @property \Cake\ORM\Association\BelongsTo $Agents
 *
 * @method \App\Model\Entity\Kill get($primaryKey, $options = [])
 * @method \App\Model\Entity\Kill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Kill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Kill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Kill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Kill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Kill findOrCreate($search, callable $callback = null, $options = [])
 */
class KillsTable extends Table
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

        $this->table('kills');
        $this->displayField('kill_id');
        $this->primaryKey('kill_id');

        $this->belongsTo('Characters', [
            'foreignKey' => 'character_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ShipTypes', [
            'foreignKey' => 'ship_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SolarSystems', [
            'foreignKey' => 'solar_system_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AgentKills',[
            'foreignKey' => 'kill_id',
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
        // $validator
        //     ->dateTime('date')
        //     ->requirePresence('date', 'create')
        //     ->notEmpty('date');

        // $validator
        //     ->numeric('value')
        //     ->requirePresence('value', 'create')
        //     ->notEmpty('value');

        // $validator
        //     ->numeric('totalWingspanPct')
        //     ->requirePresence('totalWingspanPct', 'create')
        //     ->notEmpty('totalWingspanPct');

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
        $rules->add($rules->existsIn(['character_id'], 'Characters'));
        $rules->add($rules->existsIn(['ship_type_id'], 'ShipTypes'));
        $rules->add($rules->existsIn(['solar_system_id'], 'SolarSystems'));
        // $rules->add($rules->existsIn(['kill_id'], 'Kills'));
        // $rules->add($rules->existsIn(['agent_id'], 'Agents'));

        return $rules;
    }
}
