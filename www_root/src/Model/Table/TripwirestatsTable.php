<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tripwirestats Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Characters
 *
 * @method \App\Model\Entity\Tripwirestat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tripwirestat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tripwirestat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tripwirestat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tripwirestat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tripwirestat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tripwirestat findOrCreate($search, callable $callback = null, $options = [])
 */
class TripwirestatsTable extends Table
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

        $this->table('tripwirestats');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Characters', [
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
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->integer('sigCount')
            ->requirePresence('sigCount', 'create')
            ->notEmpty('sigCount');

        $validator
            ->integer('systemsVisited')
            ->requirePresence('systemsVisited', 'create')
            ->notEmpty('systemsVisited');

        $validator
            ->integer('systemsViewed')
            ->requirePresence('systemsViewed', 'create')
            ->notEmpty('systemsViewed');

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

        return $rules;
    }
}
