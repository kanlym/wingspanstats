<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monthstats Model
 *
 * @method \App\Model\Entity\Monthstat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Monthstat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Monthstat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Monthstat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monthstat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Monthstat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Monthstat findOrCreate($search, callable $callback = null, $options = [])
 */
class MonthstatsTable extends Table
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

        $this->table('monthstats');
        $this->displayField('date');
        $this->primaryKey('statsname');
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
            ->allowEmpty('date', 'create');

        $validator
            ->requirePresence('statsname', 'create')
            ->notEmpty('statsname');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        return $validator;
    }
}
