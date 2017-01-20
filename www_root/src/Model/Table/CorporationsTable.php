<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Corporations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Corporations
 *
 * @method \App\Model\Entity\Corporation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corporation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Corporation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corporation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corporation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corporation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corporation findOrCreate($search, callable $callback = null, $options = [])
 */
class CorporationsTable extends Table
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

        $this->table('corporations');
        $this->displayField('corporation_name');
        $this->primaryKey('corporation_id');

        $this->hasMany('Characters', [
            'foreignKey' => 'character_id',
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
        //     ->requirePresence('corporation_name', 'create')
        //     ->notEmpty('corporation_name');

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
        // $rules->add($rules->existsIn(['corporation_id'], 'Corporations'));

        return $rules;
    }
}
