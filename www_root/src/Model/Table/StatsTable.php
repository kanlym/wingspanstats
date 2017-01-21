<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use Cake\Cache\Cache;
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
 * 
 * must change stats for participating not last hit
 */
class StatsTable extends Table
{
    
    public $astero = array(33468);
    public $blops = array(22430, 22440, 22428, 22436);
    public $bombers = array(11377, 12034, 12032, 12038);
    public $caps = array(
                            19724, 34339, 19722, 34341, 19726, 34343, 19720, 34345,  # Dreads
                            23757, 23915, 24483, 23911,  # Carriers
                            37604, 37605, 37606, 37607,  # Force auxiliaries
                            23919, 22852, 3628, 23913, 3514, 23917,  # Supers
                            11567, 671, 3764, 23773 );
    public $industrials = array(
                                648, 1944, 33695, 655, 651, 33689, 657, 654,  # industrials
                                652, 33693, 656, 32811, 4363, 4388, 650, 2998,  # industrials
                                2863, 19744, 649, 33691, 653,  # industrials
                                12729, 12733, 12735, 12743,  # blockade runners
                                12731, 12753, 12747, 12745,  # deep space transports
                                34328, 20185, 20189, 20187, 20183,  # freighters
                                28848, 28850, 28846, 28844,  # jump freighters
                                28606, 33685, 28352, 33687,  # orca, rorq
            );
    public $interdictors = array(
                    22460, 22464, 22452, 22456,  # interdictors
                    12013, 12017, 11995, 12021,  # heavy interdictors
        );
    public $miners = array(
                        32880, 33697, 37135,  # mining frigates
                        17476, 17480, 17478,  # mining barges
                        22544, 22548, 33683, 22546,  # exhumers
                        42244, 28606                 #  porpoise & orca
        );
    public $nestor = array(33472);
    public $pod = array(670, 33328);
    public $recons = array(11969, 11957, 11965, 11963, 20125, 11961, 11971, 11959);
    public $stratios = array(33470);
    public $strategicCruiser = array(29986, 29990, 29988, 29984);

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

    public function agents($dateStart = false,$dateEnd = false){

        $cacheKey = 'agents_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
         $query = "SELECT 
            count(ak.kill_id) as kills, c.character_name,sum(value)/1000000000 as isk from agent_kills as ak join kills on kills.kill_id = ak.kill_id
            join characters as c on c.character_id = ak.character_id
            where date > '$dateStart 00:00:00'
            and date < '$dateEnd 00:00:00'
            and totalWingspanPct > 24
           group by ak.`character_id`
            ORDER BY kills DESC";
                $connection = ConnectionManager::get('default');
                $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }

     public function ship($shipName = 'stratios',$dateStart = false,$dateEnd = false){
        $cacheKey = 'ships_' . $dateStart. '_'. $dateEnd. '_'.md5($shipName);
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT count(ak.kill_id) as noOfKills,
                        sum(damageDone) as damageDone,
                        sum(value)/1000000000 as isk,
                        'billion' as currency,
                        a.character_name as agent
                        from agent_kills as ak 
                            join characters as a on a.character_id = ak.character_id 
                            join kills on kills.kill_id = ak.kill_id 
                            join ship_types as victimShip on victimShip.ship_type_id = kills.ship_type_id 
                            join ship_types as agentShip on agentShip.ship_type_id = ak.ship_type_id
                        where  
                            kills.date > '$dateStart 00:00:00' 
                        and kills.date < '$dateEnd 00:00:00'
                        and agentShip.name = '$shipName'
                        and totalWingspanPct > 24
                        group by a.character_id
                        order by isk DESC
                        ";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }

     public function pilots($pilotName = 'Kanly Aideron',$dateStart = false,$dateEnd = false){
        $cacheKey = 'pilots_' . $dateStart. '_'. $dateEnd. '_'.md5($pilotName);
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT count(ak.kill_id) as noOfKills,
            sum(ak.killingBlow) as killingShot,
            sum(damageDone) as damageDone,
            sum(value)/1000000000 as isk,
            'billion' as currency,
            agentShip.name as shipName
                 from 
                 agent_kills as ak 
                 join characters as a on a.character_id = ak.character_id 
                 join kills on kills.kill_id = ak.kill_id 
                 join ship_types as victimShip on victimShip.ship_type_id = kills.ship_type_id 
                 join ship_types as agentShip on agentShip.ship_type_id = ak.ship_type_id
            where character_name = '$pilotName'
            and kills.date > '$dateStart 00:00:00' 
            and kills.date < '$dateEnd 00:00:00'
            and totalWingspanPct > 24
            -- and ak.killingBlow = 0
            group by ak.ship_type_id
            order by noOfKills DESC
                        ";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function locations($dateStart = false, $dateEnd = false){
        $cacheKey = 'locations_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT sum(value)/1000000000 as isk,count(kills.kill_id) as ships,system.type as system,isWh,'billion' as currency from kills
                 join solar_systems as system on system.solar_system_id = kills.solar_system_id

            where date > '$dateStart 00:00:00'  
            and date < '$dateEnd 00:00:00'
            and totalWingspanPct > 24
            and isOurLoss = 0
            group by system.type
            ORDER BY isk DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        $output = array();//formating
        $totalWhIsk = 0;
        $totalWhKills = 0;
        $wh = array();
        $details = array();
        foreach ($results as $i=>$r){
             if ($r['isWh']){
                $totalWhIsk += $r['isk'];
                $totalWhKills += $r['ships'];
                $details[] = $r;
                unset($results[$i]);
             }

        }
        $wh['isk'] = $totalWhIsk;
        $wh['ships'] = $totalWhKills;
        $wh['system'] = 'WormHole';
        $wh['currency'] = 'billion';
        $wh['isWh'] = "1";
        $wh['details'] = $details;
        foreach ($results as $r){
            $output[] = $r;
        }
        $output['wh'] = $wh;
        Cache::write($cacheKey,$output,'fivemin');
        return $output;
    }

     public function solo($dateStart = false,$dateEnd = false){
        $cacheKey = 'solo_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        $query = "SELECT sum(kills.value) /1000000000 as isk ,count(kills.kill_id) as ships_killed ,c.character_name
                    from kills join characters as c on c.character_id = kills.agent_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where killingBlow = 1
                    and isOurLoss = 0
                    and totalWingspanPct > 24
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                    and partiesInvolved = 1
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getGenericByFlownShip($ship = array(),$solo = 1, $dateStart = false, $dateEnd = false){

        $cacheKey = 'sgetGenericByFlownShip_' . $dateStart. '_'. $dateEnd . '_'. $solo .'_' . md5(implode('_',$ship));
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }       
        $ships = implode(',',$ship);
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }

          $query = "SELECT sum(kills.value)/1000000000 as isk ,count(kills.kill_id ) as ships_killed ,c.character_name,agntShip.name as agentFlying
                    from kills 
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                     -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join characters as c on c.character_id = ak.character_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where isOurLoss = 0
                    and totalWingspanPct > 24
                    -- and isKillingBlows = 1 #FOR SOLO
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                    and agntShip.ship_type_id in ($ships)      
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }       
    public function getGenericByDestroyedShip($ship = array(),$solo = 1, $dateStart = false, $dateEnd = false){
         $cacheKey = 'getGenericByDestroyedShip_' . $dateStart. '_'. $dateEnd . '_'. $solo .'_' . md5(implode('_',$ship));
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $ships = implode(',',$ship);
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }
          $query = "SELECT sum(kills.value)/1000000000 as isk ,count(kills.kill_id ) as ships_killed ,c.character_name,agntShip.name as agentFlying
                    from kills 
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                    -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join characters as c on c.character_id = ak.character_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where isOurLoss = 0
                    and totalWingspanPct > 24
                    -- and isKillingBlows = 1 #FOR SOLO
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                    and kills.ship_type_id in ($ships)      
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
     public function getExplorerKills($solo = 1, $dateStart = false, $dateEnd = false){
         $cacheKey = 'getExplorerKills' . $dateStart. '_'. $dateEnd . '_'. $solo;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }
          $query = "SELECT sum(kills.value) / 1000000000 as isk ,count(kills.kill_id) as kills ,c.character_name
                    from kills join characters as c on c.character_id = kills.agent_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                    -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where
                    isExplorer = 1
                    -- and isKillingBlows = 1 #FOR SOLO
                    and isOurLoss = 0
                    and totalWingspanPct > 24
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                    $soloConditions
                    group by c.character_id
                    ORDER by kills DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
      public function getGenericShipFlownShipDestroyed($agntShip = array(),$vicShip = array(),$solo = 1, $dateStart = false, $dateEnd = false){
        $cacheKey = 'getGenericShipFlownShipDestroyed_' . $dateStart. '_'. $dateEnd . '_'. $solo .'_' . implode('_',$agntShip) .implode('_',$vicShips);
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $agntShips = implode(',',$agntShip);
        $vicShips = implode(',',$vicShip);
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }
          $query = "SELECT sum(kills.value)/1000000000 as isk ,count(kills.kill_id ) as ships_killed ,c.character_name,agntShip.name as agentFlying
                    from kills 
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                    -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join characters as c on c.character_id = ak.character_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where isOurLoss = 0
                    -- and isKillingBlows = 1 #FOR SOLO
                    and totalWingspanPct > 24
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                    and kills.ship_type_id in ($vicShips) 
                    and ak.ship_type_id in ($agntShips)     
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    
    public function getLosses($dateStart = false,$dateEnd = false){
        $cacheKey = 'getLosses_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $query = "SELECT sum(kills.value)/1000000000 as isk,
    kills.character_id,c.character_name,ship.name,count(kills.kill_id) as kills from kills 
    join characters as c on c.character_id = kills.character_id
    join ship_types as ship on ship.ship_type_id = kills.ship_type_id
    where isOurLoss = 1
    and date > '$dateStart 00:00:00'
    and date < '$dateEnd 00:00:00'    
    
    
    group by kills.character_id
    order by kills DESC;";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getBiggestLoss($dateStart = false,$dateEnd = false){
        $cacheKey = 'getBiggestLoss_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT kills.value/1000000000 as isk,
                    kills.character_id,c.character_name,ship.name,kills.kill_id from kills 
                    join characters as c on c.character_id = kills.character_id
                    join ship_types as ship on ship.ship_type_id = kills.ship_type_id
                    where isOurLoss = 1
                    and date > '$dateStart 00:00:00'
                    and date < '$dateEnd 00:00:00'    
                    
                    order by isk DESC;";
         $connection = ConnectionManager::get('default');
        $data = $connection->execute($query)->fetchAll('assoc');
        // debug($data);die();
        $characters = array();
        foreach ($data as $d){
            $id = $d['character_id'];
            if (!isset($characters[$id]))
                { $characters[$id] = array(
                            'isk'=>$d['isk'],
                            'max'=>$d['isk'],
                            'character_name' => $d['character_name'],
                            'name'=>$d['name']
                            );
            }else{
                if ($d['isk'] > $characters[$id]['max'])
                     $characters[$id] = array('isk'=>$d['isk'],'max'=>$d['isk'],'character_name' => $d['character_name'],'name'=>$d['name']);
            }
        }
        $results = array();
        foreach ($characters as $c){
            $results[] = $c;
        }
        usort($results,'cmpISK');
        Cache::write($cacheKey,$data,'fivemin');
        return $results;
    }
    public function miniBlops( $dateStart = false, $dateEnd = false){
         $cacheKey = 'miniBlops_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT sum(kills.value) / 1000000000 as isk ,count(kills.kill_id) as ships_killed ,c.character_name,partiesInvolved
                    from kills join characters as c on c.character_id = kills.agent_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where  partiesInvolved < 5
                    and totalWingspanPct > 24
                    and isOurLoss = 0
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                    and agntShip.ship_type_id in ($ships)
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getAverageDestroyed( $dateStart = false, $dateEnd = false){
        $cacheKey = 'getAverageDestroyed_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT 
                    kills.value/1000000000 /  count(kills.kill_id)  as efficency,
                    count(kills.kill_id) as shipsDestroyed,
                    avg(kills.value)/1000000000 as avgValue,
                    kills.value/1000000000 as totalValue,
                    c.character_name 
                FROM kills
                    JOIN characters as c on c.character_id = kills.agent_id
                WHERE 
                    isOurLoss = 0
                    and totalWingspanPct > 24
                    and c.character_id > 0
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date < '$dateEnd 00:00:00'
                GROUP BY c.character_id
                ORDER BY efficency DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getAverageLost( $dateStart = false, $dateEnd = false){
         $cacheKey = 'getAverageLost_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT 
                        kills.value/1000000000 /  count(kills.kill_id)  as efficency,
                        count(kills.kill_id) as shipsDestroyed,
                        avg(kills.value)/1000000000 as avgValue,
                        kills.value/1000000000 as totalValue,
                        c.character_name 
                    FROM kills
                        JOIN characters as c on c.character_id = kills.character_id
                    WHERE 
                        isOurLoss = 1
                        and c.character_id > 0
                        and kills.date > '$dateStart 00:00:00'
                        and kills.date < '$dateEnd 00:00:00'
                    GROUP BY c.character_id
                    ORDER BY efficency DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }  
    public function topShips( $dateStart = false, $dateEnd = false){
         $cacheKey = 'topShips_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT sum(kills.value)/1000000000 as isk, count(kills.kill_id) as totalKills, ship.name from agent_kills as ak
                        join kills on kills.kill_id = ak.kill_id
                        join ship_types as ship on ship.ship_type_id = ak.ship_type_id
                    WHERE 
                        kills.isOurLoss = 0
                        and totalWingspanPct >24
                        and kills.date > '$dateStart 00:00:00'
                        and kills.date < '$dateEnd 00:00:00'
                    GROUP BY ship.ship_type_id
                    ORDER BY isk DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
         Cache::write($cacheKey,$results,'fivemin');
        return $results;
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
