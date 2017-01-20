<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Characters Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Characters
 *
 * @method \App\Model\Entity\Character get($primaryKey, $options = [])
 * @method \App\Model\Entity\Character newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Character[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Character|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Character patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Character[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Character findOrCreate($search, callable $callback = null, $options = [])
 */
class CharactersTable extends Table
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

        $this->table('characters');
        $this->displayField('character_name');
        $this->primaryKey('character_id');
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
        // $validator
        //     ->requirePresence('character_name', 'create')
        //     ->notEmpty('character_name');

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
        // $rules->add($rules->existsIn(['character_id'], 'Characters'));

        return $rules;
    }
}
