<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SolarSystems Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SolarSystems
 *
 * @method \App\Model\Entity\SolarSystem get($primaryKey, $options = [])
 * @method \App\Model\Entity\SolarSystem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SolarSystem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SolarSystem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SolarSystem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SolarSystem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SolarSystem findOrCreate($search, callable $callback = null, $options = [])
 */
class SolarSystemsTable extends Table
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

        $this->table('solar_systems');
        $this->displayField('name');
        $this->primaryKey('solar_system_id');

        // $this->belongsTo('SolarSystems', [
        //     'foreignKey' => 'solar_system_id',
        //     'joinType' => 'INNER'
        // ]);
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
        // $rules->add($rules->existsIn(['solar_system_id'], 'SolarSystems'));

        return $rules;
    }
}
