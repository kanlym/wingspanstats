<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AgentKills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Characters
 * @property \Cake\ORM\Association\BelongsTo $Kills
 * @property \Cake\ORM\Association\BelongsTo $ShipTypes
 * @property \Cake\ORM\Association\BelongsTo $Corporations
 *
 * @method \App\Model\Entity\AgentKill get($primaryKey, $options = [])
 * @method \App\Model\Entity\AgentKill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AgentKill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AgentKill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AgentKill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AgentKill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AgentKill findOrCreate($search, callable $callback = null, $options = [])
 */
class AgentKillsTable extends Table
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

        $this->table('agent_kills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Characters', [
            'foreignKey' => 'character_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Kills', [
            'foreignKey' => 'kill_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ShipTypes', [
            'foreignKey' => 'ship_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Corporations', [
            'foreignKey' => 'corporation_id',
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
        $rules->add($rules->existsIn(['kill_id'], 'Kills'));
        $rules->add($rules->existsIn(['ship_type_id'], 'ShipTypes'));
        $rules->add($rules->existsIn(['corporation_id'], 'Corporations'));

        return $rules;
    }
}
